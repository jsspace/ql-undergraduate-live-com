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
    const INCOMEP = 0.2; // 直接收益提成
    const INCOMENEXTP = 0.2; // 间接收益提成

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

    // 获取所有学员id @zhang
    public static function getStudentIds($invite_id) {
        $students = User::find()
        ->where(['invite' => $invite_id])
        ->with(['role' => function($query) {
            $query->where(['item_name' => 'student']);
        }])
        ->all();
        $student_ids = array();
        foreach ($students as $student) {
            if (count($student->role) > 0) {
                $student_ids[] = $student->id;
            }
        }
        return $student_ids;
    }
    // 获取直接下级id @zhang
    public static function getMarketIds($invite_id) {
        $market_ids = array();
        $marketers = User::find()
        ->where(['invite' => $invite_id])
        ->with(['role' => function($query) {
            $query->where(['item_name' => 'marketer']);
        }])
        ->all();
        foreach ($marketers as $key => $marketer) {
            if (count($marketer->role) > 0) {
                $market_ids[] = $marketer->id;
            }
        }
        return $market_ids;
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    // 递归计算当前用户的按月统计收益 @zhang
    public static function getMonthIncome($id) {
        $market_ids = self::getMarketIds($id);
        // 直接下级为空
        if (count($market_ids) == 0) {
            $student_ids = self::getStudentIds($id);
            $direct_orders = OrderInfo::find()
            ->select(["sum(order_amount)*".self::INCOMEP." as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])
            ->asArray()
            ->all();
            return $direct_orders;
        } else {
            $student_ids = self::getStudentIds($id);
            $direct_orders = OrderInfo::find()
            ->select(["sum(order_amount)*".self::INCOMEP." as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(['order_status' => 1])->andWhere(['pay_status' => 2])
            ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])
            ->asArray()
            ->all();
            foreach ($market_ids as $key => $market_id) {
                $sub_income = self::getMonthIncome($market_id); // 获取每个子代理的总收益
                foreach ($sub_income as &$income) {
                    $income['income'] = $income['income'] * self::INCOMENEXTP;
                }
                unset($income);
                $direct_orders = array_merge($direct_orders, $sub_income);
                for ($i = 0; $i < count($direct_orders)-1; $i++) {
                    for ($j = $i+1; $j < count($direct_orders); $j++) {
                        if ($direct_orders[$i]['month'] == $direct_orders[$j]['month']) {
                            $direct_orders[$i]['income'] += $direct_orders[$j]['income'] ;
                            unset($direct_orders[$j]);
                            $direct_orders = array_values($direct_orders);
                            $j = $j-1;
                        }
                    }
                }
            }
            return $direct_orders;
        }
    }

    // 按月统计收入明细
    public function actionOrder($userid, $username) {
        $my_income = self::getMonthIncome($userid);
        array_multisort(array_column($my_income,'month'),SORT_DESC,$my_income);
        foreach ($my_income as $key => $item) {
            // 查询每个月的提成是否已经确认提现
            $withdraw_info = Withdraw::find()
            ->where(['user_id' => $userid, 'withdraw_date' => $my_income[$key]['month']])->one();
            $my_income[$key]['status'] = !empty($withdraw_info) ? '已结算' : '未结算';
        }
        return $this->render('order',[
            'income' => $my_income,
            'userid' => $userid,
            'username' => $username
        ]);
    }

    // 递归计算用户的某一个月份的统计收益 @zhang
    public static function getOneMonthIncome($id, $month) {
        $market_ids = self::getMarketIds($id);
        // 直接下级为空
        if (count($market_ids) == 0) {
            $student_ids = self::getStudentIds($id);
            $direct_orders = OrderInfo::find()
            ->select(["sum(order_amount)*".self::INCOMEP." as income"])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m')" => $month])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->asArray()
            ->all();
            return $direct_orders[0]['income'];
        } else {
            $student_ids = self::getStudentIds($id);
            $direct_orders = OrderInfo::find()
            ->select(["sum(order_amount)*".self::INCOMEP." as income"])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m')" => $month])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->asArray()
            ->all();
            $income = $direct_orders[0]['income'];
            foreach ($market_ids as $key => $market_id) {
                $sub_income = self::getOneMonthIncome($market_id, $month); // 获取每个子代理的总收益
                $income += $sub_income * self::INCOMENEXTP;
            }
            return $income;
        }
    }

    // 具体月份收益明细（直接和间接）@zhang
    public function actionOrderDetail($userid, $month, $username) {
        $direct_income = array();
        // 1、查询直接注册的用户
        $student_ids = self::getStudentIds($userid);
        // 2、根据直接注册的用户查询邀请的用户下单情况并计算收益
        $orders = OrderInfo::find()->select(['consignee', 'order_amount', 'pay_time', 'user_id'])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m')" => $month])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->all();
        foreach ($orders as $order) {
            $userpic = User::find()->select(['picture'])
            ->where(['id' => $order->user_id])
            ->one();
            $order_content = array(
                'pic' => $userpic->picture,
                'consignee' => $order->consignee,
                'order_amount' => $order->order_amount,
                'income' => round($order->order_amount * self::INCOMEP, 2),
                'pay_time' => date('Y-m-d H:i:s', $order->pay_time)
            );
            $direct_income[] = $order_content;
        }
        array_multisort(array_column($direct_income,'pay_time'),SORT_DESC, $direct_income);
        
        // 1、查找自己的直接下级代理
        $market_ids = self::getMarketIds($userid);
        $indirect_income = array();
        // 2、查找每个直接下级代理所邀请的学生的订单
        foreach ($market_ids as $market_id) {
            $income = self::getOneMonthIncome($market_id, $month);
            // 3、将订单信息添加到数组并计算该笔订单的间接收益
            $user = User::find()
            ->select(['picture', 'username'])
            ->where(['id' => $market_id])
            ->one();
            if ($income > 0) {
                $order_content = array(
                    'pic' => $user->picture,
                    'username' => $user->username,
                    'income' => $income,
                    'tc' => $income * self::INCOMENEXTP
                );
                $indirect_income[] = $order_content;
            }
        }

        return $this->render('order-detail',[
            'direct' => $direct_income,
            'indirect' => $indirect_income,
            'username' => $username
        ]);
    }
    public function actionOrder1($userid, $month=null)
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
