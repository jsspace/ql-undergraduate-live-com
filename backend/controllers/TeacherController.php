<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\Course;
use backend\models\CoursePackage;
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
    const INCOMEP = 0.15; // 教师收益提成
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
            $teacher_income += $t_total_price/$course_total_price*$order_money*self::INCOMEP;
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
    // 按月统计收入明细
    public function actionOrder($userid, $username) {
        if (!empty($userid)) {
            // 1、查找属于自己的课程
            $order_ids = array();   // 记录自己课程（套餐）的id并记录所占比例
            $courses_arr = array();
            $courses = Course::find()->select(['id'])->where(['teacher_id' => $userid])->all();
            foreach ($courses as $course) {
                $order_ids[$course->id] = 1;
                $courses_arr[] = $course->id;
            }
            // 2、查找套餐内包含自己课程的套餐
            $packges = CoursePackage::find()->select(['id', 'course', 'discount'])->all();
            foreach ($packges as $package) {
                // 求数据交集，查看哪门套餐包含自己的课程
                $pack_courses_arr = explode(',', $package->course);
                $inter_arr = array_intersect($courses_arr, $pack_courses_arr);
                $include_arr = array_values($inter_arr);    // 该数组包含了每一个套餐内所含自己课程的数组

                if (count($include_arr) != 0) {
                    // 计算每个套餐内自己课程所占的比例
                    $pack_totle_discount = 0.0;
                    $include_totle_discount = 0.0;
                    $pack_courses = Course::find()->select(['discount'])
                        ->where(['in', 'id', $pack_courses_arr])
                        ->all();
                    // 计算套餐内所有单门课程的售价总和
                    foreach ($pack_courses as $pack_course) {
                        $pack_totle_discount = $pack_totle_discount + $pack_course->discount;
                    }
                    $include_courses = Course::find()->select(['discount'])
                        ->where(['in', 'id', $include_arr])
                        ->all();
                    // 计算套餐内自己课程的售价总和
                    foreach ($include_courses as $include_course) {
                        $include_totle_discount = $include_totle_discount + $include_course->discount;
                    }
                    $rate = $include_totle_discount / $pack_totle_discount;
                    $order_ids[$package->id] = $rate;
                }
            }
            // 查找订单信息，计算收益
            $orders = OrderGoods::find()
                ->select(['order_sn', 'goods_id'])
                ->where(['in', 'goods_id', array_keys($order_ids)])
                ->all();
            $income_arr = array();
            foreach ($orders as $order) {
                $order_sn[] = $order->order_sn;
                $order_info = OrderInfo::find()
                    ->select(['consignee', 'order_amount', "DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
                    ->where(['order_sn' => $order->order_sn])
                    ->andWhere(['pay_status' => 2])
                    ->andWhere(['order_status' => 1])
                    ->asArray()->one();
                if (!empty($order_info)) {
                    $income_arr[] = array(
                        'month' => $order_info['month'],
                        'income' => $order_info['order_amount'] * $order_ids[$order->goods_id],
                        'salary' => $order_info['order_amount'] * $order_ids[$order->goods_id] * self::INCOMEP
                    );
                }
            }

            // 将月份相同的课程收益合并
            $my_income = array();
            for ($i = 0; $i < count($income_arr)-1; $i++) {
                for ($j = 0; $j < count($income_arr); $j++) {
                    if ($income_arr[$i]['month'] == $income_arr[$j]['month'] and $i != $j) {
                        $income_arr[$i]['income'] += $income_arr[$j]['income'] ;
                        $income_arr[$i]['salary'] += $income_arr[$j]['salary'] ;
                        unset($income_arr[$j]);
                        $income_arr = array_values($income_arr);
                        $j = $j-1;
                    }
                }
            }
            $my_income = $income_arr;
            // 对结果按照月份降序排序
            array_multisort(array_column($my_income,'month'),SORT_DESC,$my_income);
            foreach ($my_income as $key => $item) {
                $my_income[$key]['income'] = round($my_income[$key]['income'], 4);
                $my_income[$key]['salary'] = round($my_income[$key]['salary'], 4);
                $withdraw_info = Withdraw::find()
                ->where(['user_id' => $userid, 'withdraw_date' => $my_income[$key]['month']])
                ->one();
                $status_text = '未结算';
                if (!empty($withdraw_info)) {
                    if ($withdraw_info->status === 1) {
                        $status_text = '已结算';
                    } else if ($withdraw_info->status === 0) {
                        $status_text = '申请中';
                    }
                }
                $my_income[$key]['status'] = $status_text;
            }
            return $this->render('order',[
                'income' => $my_income,
                'userid' => $userid,
                'username' => $username
            ]);
        }
    }
    // 具体月份收益明细（直接和间接）@zhang
    public function actionOrderDetail($userid, $month, $username) {
        $result = array();
        if (!empty($userid)) {
            // 1、查找属于自己的课程
            $order_ids = array();   // 记录自己课程（套餐）的id并记录所占比例
            $courses_arr = array();
            $courses = Course::find()->select(['id'])->where(['teacher_id' => $userid])->all();
            foreach ($courses as $course) {
                $order_ids[$course->id] = 1;
                $courses_arr[] = $course->id;
            }
            // 2、查找套餐内包含自己课程的套餐
            $packges = CoursePackage::find()->select(['id', 'course', 'discount'])->all();
            foreach ($packges as $package) {
                // 求数据交集，查看哪门套餐包含自己的课程
                $pack_courses_arr = explode(',', $package->course);
                $inter_arr = array_intersect($courses_arr, $pack_courses_arr);
                $include_arr = array_values($inter_arr);    // 该数组包含了每一个套餐内所含自己课程的数组
                if (count($include_arr) != 0) {
                    // 计算每个套餐内自己课程所占的比例
                    $pack_totle_discount = 0.0;
                    $include_totle_discount = 0.0;
                    $pack_courses = Course::find()->select(['discount'])
                        ->where(['in', 'id', $pack_courses_arr])
                        ->all();
                    // 计算套餐内所有单门课程的售价总和
                    foreach ($pack_courses as $pack_course) {
                        $pack_totle_discount = $pack_totle_discount + $pack_course->discount;
                    }
                    $include_courses = Course::find()->select(['discount'])
                        ->where(['in', 'id', $include_arr])
                        ->all();
                    // 计算套餐内自己课程的售价总和
                    foreach ($include_courses as $include_course) {
                        $include_totle_discount = $include_totle_discount + $include_course->discount;
                    }
                    $rate = $include_totle_discount / $pack_totle_discount;
                    $order_ids[$package->id] = $rate;
                }
            }
            // 查找订单信息，计算收益
            $orders = OrderGoods::find()
                ->select(['order_sn', 'goods_id'])
                ->where(['in', 'goods_id', array_keys($order_ids)])
                ->all();
            $income_detail = array();
            foreach ($orders as $order) {
                $order_sn[] = $order->order_sn;
                $order_info = OrderInfo::find()
                    ->select(['consignee', 'order_amount', 'user_id', 'pay_time'])
                    ->where(['order_sn' => $order->order_sn])
                    ->andWhere(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m')" => $month])
                    ->andWhere(['pay_status' => 2])
                    ->andWhere(['order_status' => 1])
                    ->one();
                if (!empty($order_info)) {
                    $userpic = User::find()->select(['picture'])
                        ->where(['id' => $order_info->user_id])
                        ->one();
                    $user_head = '';
                    if (!empty($userpic)) {
                        $user_head = $userpic->picture;
                    }
                    $income_content = array(
                        'pic' => $user_head,
                        'consignee' => $order_info->consignee,
                        'order_amount' => $order_info['order_amount'],
                        'status' => '下单',
                        'income' => round($order_info['order_amount'] * $order_ids[$order->goods_id] * self::INCOMEP, 4),
                        'pay_time' => date('Y-m-d H:i:s', $order_info->pay_time)
                    );
                    $income_detail[] = $income_content;
                }
            }
            return $this->render('order-detail',[
                'income' => $income_detail,
                'username' => $username
            ]);
        }
    }
}
