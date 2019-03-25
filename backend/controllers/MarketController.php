<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\MarketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\controllers\ApiController;
use backend\models\AuthAssignment;
use yii\web\UploadedFile;
use Da\QrCode\QrCode;
use backend\models\OrderInfo;
use yii\data\Pagination;
use backend\models\Withdraw;

/**
 * MarketController implements the CRUD actions for User model.
 */
class MarketController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if (!array_key_exists('admin',$roles_array) && $id != Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $marketer = User::find()
        ->where(['id' => $id])
        ->one();
        $invite_users = User::find()
        ->where(['cityid' => $marketer->cityid])
        ->all();
        $invite_users_id = [];
        foreach($invite_users as $user) {
            $invite_users_id[] = $user->id;
        }
        //计算订单抽成
        $orders = OrderInfo::find()
        ->where(['user_id' => $invite_users_id])
        ->andWhere(['order_status' => 1])
        ->andWhere(['pay_status' => 1])
        ->all();
        $fee = 0.00;
        foreach($orders as $order) {
            $fee += $order->order_amount * 0.1;
        }
        
        return $this->render('view', [
            'fee' => $fee,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionOrder($userid, $month=null)
    {
        $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if (!array_key_exists('admin',$roles_array) && $userid != Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $marketer = User::find()
        ->where(['id' => $userid])
        ->one();
        $invite_users = User::find()
        ->where(['cityid' => $marketer->cityid])
        ->all();
        $invite_users_id = [];
        foreach($invite_users as $user) {
            $invite_users_id[] = $user->id;
        }
        if ($month) {
            $timestamp = strtotime($month);
            $start_time = strtotime(date( 'Y-m-1 00:00:00', $timestamp ));
            $mdays = date( 't', $timestamp );
            $end_time = strtotime(date( 'Y-m-' . $mdays . ' 23:59:59', $timestamp ));
            //邀请的用户所下的订单
            $data = OrderInfo::find()
            ->where(['user_id' => $invite_users_id])
            ->andWhere(['between', 'add_time', $start_time, $end_time])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->orderBy('order_id desc');
            
            //计算市场专员报酬
            $income_orders_models = OrderInfo::find()
            ->where(['user_id' => $invite_users_id])
            ->andWhere(['between', 'add_time', $start_time, $end_time])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->all();
        } else {
            //邀请的用户所下的订单
            $data = OrderInfo::find()
            ->where(['user_id' => $invite_users_id])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->orderBy('order_id desc');
            
            //计算市场专员报酬
            $income_orders_models = OrderInfo::find()
            ->where(['user_id' => $invite_users_id])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->all();
        }
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '10']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        
        
        $market_income = 0;
        foreach ($income_orders_models as $item) {
            $market_income += $item->order_amount + $item->bonus;
        }
        $market_total_income = $market_income * 0.5;
        
        //提现历史
        $withdraw_history = Withdraw::find()
        ->where(['user_id' => $userid])
        ->andWhere(['status' => 1])
        ->all();
        $total_withdraw = 0;
        foreach($withdraw_history as $withdraw) {
            $total_withdraw += $withdraw->fee;
        }
        return $this->render('order',[
            'model' => $model,
            'pages' => $pages,
            'market_total_income' => $market_total_income,
            'total_withdraw' => $total_withdraw,
        ]);
    }
    

    
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->status = 10;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $role = new AuthAssignment();
            $role->item_name = 'marketer';
            $role->user_id = $model->id;
            $role->save(false);
            
            $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
            $file = UploadedFile::getInstance($model, 'picture');
             
            if ($file) {
                $ext = $file->getExtension();
                $randName = time() . rand(1000, 9999) . '.' . $ext;
                $img_rootPath .= 'head_img/';
                if (!file_exists($img_rootPath)) {
                    mkdir($img_rootPath, 0777, true);
                }
                $file->saveAs($img_rootPath . $randName);
                $model->picture = '/'.Yii::$app->params['upload_img_dir'] . 'head_img/' . $randName;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
            
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if (!array_key_exists('admin',$roles_array) && $id != Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
            $file = UploadedFile::getInstance($model, 'picture');
             
            if ($file) {
                $ext = $file->getExtension();
                $randName = time() . rand(1000, 9999) . '.' . $ext;
                $img_rootPath .= 'head_img/';
                if (!file_exists($img_rootPath)) {
                    mkdir($img_rootPath, 0777, true);
                }
                $file->saveAs($img_rootPath . $randName);
                $model->picture = '/'.Yii::$app->params['upload_img_dir'] . 'head_img/' . $randName;
            }
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $role = AuthAssignment::deleteAll(['user_id' => $id]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionQrcode($url, $name)
    {
        $qrCode = (new QrCode($url))
        ->setSize(250)
        ->setMargin(5)
        ->useForegroundColor(51, 153, 255);
    
        // now we can display the qrcode in many ways
        // saving the result to a file:
        $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'] . 'qrcode_img/';
        $qrCode->writeFile($img_rootPath . $name); // writer defaults to PNG when none is specified
        
        // display directly to the browser 
        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
    }
}
