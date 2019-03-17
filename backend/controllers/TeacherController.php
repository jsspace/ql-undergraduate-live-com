<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\Course;
use backend\models\TeacherSearch;
use backend\models\OrderInfo;
use backend\models\OrderGoods;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AuthAssignment;
use yii\web\UploadedFile;
use backend\models\Withdraw;
use yii\data\Pagination;
use components\helpers\QiniuUpload;

/**
 * TeacherController implements the CRUD actions for User model.
 */
class TeacherController extends Controller
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
        $searchModel = new TeacherSearch();
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $model->status = 10;
        if ($model->load(Yii::$app->request->post())) {
            $image_picture = UploadedFile::getInstance($model, 'picture');
            if ($image_picture) {
                $ext = $image_picture->getExtension();
                $randName = time() . rand(1000, 9999) . '.' . $ext;
                $rootPath .= 'teacher/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $image_picture->saveAs($rootPath . $image_picture);
                $folder = 'teacher';
                $result = QiniuUpload::uploadToQiniu($image_picture, $rootPath . $randName, $folder);
                if (!empty($result)) {
                    $model->picture = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                    @unlink($rootPath . $randName);
                }
            }
            if ($model->save(false)) {
                $role = new AuthAssignment();
                $role->item_name = 'teacher';
                $role->user_id = $model->id;
                $role->save(false);
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
        $model = $this->findModel($id);
        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $oldpicture_path = $model->picture;
        if ($model->load(Yii::$app->request->post())) {
            $image_picture = UploadedFile::getInstance($model, 'picture');
            if ($image_picture) {
                $ext = $image_picture->getExtension();
                $randName = time() . rand(1000, 9999) . '.' . $ext;
                $rootPath = $rootPath . 'teacher/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $image_picture->saveAs($rootPath . $randName);
                $folder = 'teacher';
                $result = QiniuUpload::uploadToQiniu($image_picture, $rootPath . $randName, $folder);
                if (!empty($result)) {
                    $model->picture = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                    @unlink($rootPath . $randName);
                }
            } else {
                $model->picture = $oldpicture_path;
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

        return $this->redirect(['index']);
    }

    public function actionIncomeStatistics($userid, $month=null)
    {
        $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if(!array_key_exists('admin',$roles_array) && $userid !== Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $courses = Course::find()
        ->select('id')
        ->where(['teacher_id' => $userid])
        ->asArray()
        ->all();//教师所授课程
        $course_ids = array_column($courses, 'id');
        //个人订单
        $order_goods = OrderGoods::find()
        ->select('order_sn')
        ->distinct()
        ->where(['goods_id' => $course_ids])
        ->asArray()
        ->all();
        $order_sns = array_column($order_goods, 'order_sn');
        if ($month) {
            $timestamp = strtotime($month);
            $start_time = strtotime(date( 'Y-m-1 00:00:00', $timestamp ));
            $mdays = date( 't', $timestamp );
            $end_time = strtotime(date( 'Y-m-' . $mdays . ' 23:59:59', $timestamp ));
            $orders = OrderInfo::find()
            ->where(['order_sn' => $order_sns])
            ->andWhere(['between', 'add_time', $start_time, $end_time])
            ->andWhere(['pay_status' => 2])
            ->andWhere(['order_status' => 1])
            ->orderBy('order_id desc');
            
            //计算教师总收入
            $income_orders_models = OrderInfo::find()
            ->where(['order_sn' => $order_sns])
            ->andWhere(['between', 'add_time', $start_time, $end_time])
            ->andWhere(['pay_status' => 2])
            ->andWhere(['order_status' => 1])
            ->all();
        } else {
            $orders = OrderInfo::find()
            ->where(['order_sn' => $order_sns])
            ->andWhere(['pay_status' => 2])
            ->andWhere(['order_status' => 1])
            ->orderBy('order_id desc');
            
            //计算教师总收入
            $income_orders_models = OrderInfo::find()
            ->where(['order_sn' => $order_sns])
            ->andWhere(['pay_status' => 2])
            ->andWhere(['order_status' => 1])
            ->all();
        }
        
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $orders->count(),
        ]);
        $orders = $orders->offset($pagination->offset)->limit($pagination->limit)->all();
        
        
        $teacher_income = 0;
        $order_money = 0;
        foreach ($income_orders_models as $income_orders_item) {
            // 当前订单金额
            $order_money = $income_orders_item->order_amount + $income_orders_item->bonus;
            // 获取当前订单中的所有课程
            $curr_courses = Course::getCourse($income_orders_item->course_ids);
            // 当前订单中所有课程的总价
            $course_total_price = 0;
            // 当前订单中教师所教授课程的价格
            $t_total_price = 0;
            foreach ($curr_courses as $key => $course_item) {
                $course_total_price += $course_item->discount;
                if (in_array($course_item->id, $course_ids) ) {
                    $t_total_price += $course_item->discount;
                }
            }
            $teacher_income += $t_total_price/$course_total_price*$order_money*0.5;
        }
        $teacher_total_income = round($teacher_income, 2);
        
        //提现历史
        $withdraw_history = Withdraw::find()
        ->where(['user_id' => $userid])
        ->all();
        $total_withdraw = 0;
        foreach($withdraw_history as $withdraw) {
            $total_withdraw += $withdraw->fee;
        }
        return $this->render('income-statistics', [
            'orders' => $orders,
            'pagination' => $pagination,
            't_course_ids' => $course_ids,
            'withdraw_history' => $withdraw_history,
            'total_withdraw' => $total_withdraw,
            'teacher_total_income' => $teacher_total_income,
        ]);
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
}
