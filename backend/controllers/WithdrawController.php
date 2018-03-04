<?php

namespace backend\controllers;

use Yii;
use backend\models\Withdraw;
use backend\models\WithdrawSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;
use yii\data\Pagination;
use backend\models\OrderInfo;
use backend\models\Course;
use backend\models\OrderGoods;

/**
 * WithdrawController implements the CRUD actions for Withdraw model.
 */
class WithdrawController extends Controller
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
     * Lists all Withdraw models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Withdraw model.
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
     * Creates a new Withdraw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Withdraw();
        $marketer = User::users('marketer');
        $teacher = User::users('teacher');
        $user = array_merge($marketer, $teacher);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->withdraw_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    /**
     * Updates an existing Withdraw model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $marketer = User::users('marketer');
        $teacher = User::users('teacher');
        $user = array_merge($marketer, $teacher);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->withdraw_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    /**
     * Deletes an existing Withdraw model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Withdraw model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Withdraw the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Withdraw::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Displays a single Withdraw model.
     * @param integer $id
     * @return mixed
     */
    public function actionWithdraw($id)
    {
        $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if (!array_key_exists('admin',$roles_array) && $id != Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        //提现历史
        $data = Withdraw::find()
        ->where(['user_id' => $id])
        ->orderBy('withdraw_id desc');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '10']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('withdraw',[
            'model' => $model,
            'pages' => $pages,
        ]);
    }
    
    public function actionGetlastmonthwithdraw()
    {
        $markets = User::getUserByrole('marketer');
        $last_month_first_day = strtotime(date('Y-m-01 00:00:00', strtotime('-1 month')));
        $last_month_last_day = strtotime(date('Y-m-t 23:59:59', strtotime('-1 month')));
        
        foreach ($markets as $market) {
            $invite_users = User::find()
            ->where(['cityid' => $market->cityid])
            ->all();
            $invite_users_id = [];
            foreach($invite_users as $user) {
                $invite_users_id[] = $user->id;
            }
            
            //计算市场专员报酬
            $income_orders_models = OrderInfo::find()
            ->where(['user_id' => $invite_users_id])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->andWhere(['between', 'add_time', $last_month_first_day, $last_month_last_day])
            ->all();
            $market_income = 0;
            foreach ($income_orders_models as $item) {
                $market_income += $item->order_amount + $item->bonus;
            }
            $market_total_income = $market_income * 0.5;
            //插入一条记录到提现记录表
            $is_market_withdraw_exist = Withdraw::find()
            ->where(['user_id' => $market->id])
            ->andWhere(['withdraw_date' => date('Y-m', strtotime('-1 month'))])
            ->one();
            if (empty($is_market_withdraw_exist)) {
                $withdraw = new Withdraw();
                $withdraw->role = 'marketer';
                $withdraw->user_id = $market->id;
                $withdraw->fee = $market_total_income;
                $withdraw->withdraw_date = date('Y-m', strtotime('-1 month'));
                $withdraw->bankc_card = $market->bankc_card;
                $withdraw->bank = $market->bank;
                $withdraw->bank_username = $market->bank_username;
                $withdraw->status = 0;
                $withdraw->save(false);
            }
            
            
        }
        
        $teachers = User::getUserByrole('teacher');
        foreach ($teachers as $teacher) {
            $courses = Course::find()
            ->select('id')
            ->where(['teacher_id' => $teacher->id])
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
            //计算教师总收入
            $income_orders_models = OrderInfo::find()
            ->where(['order_sn' => $order_sns])
            ->andWhere(['pay_status' => 2])
            ->andWhere(['order_status' => 1])
            ->andWhere(['between', 'add_time', $last_month_first_day, $last_month_last_day])
            ->all();
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
            
            //插入一条记录到提现记录表
            $is_teacher_withdraw_exist = Withdraw::find()
            ->where(['user_id' => $teacher->id])
            ->andWhere(['withdraw_date' => date('Y-m', strtotime('-1 month'))])
            ->one();
            if (empty($is_teacher_withdraw_exist)) {
                $withdraw = new Withdraw();
                $withdraw->role = 'teacher';
                $withdraw->user_id = $teacher->id;
                $withdraw->fee = $teacher_total_income;
                $withdraw->withdraw_date = date('Y-m', strtotime('-1 month'));
                $withdraw->bankc_card = $teacher->bankc_card;
                $withdraw->bank = $teacher->bank;
                $withdraw->bank_username = $teacher->bank_username;
                $withdraw->status = 0;
                $withdraw->save(false);
            }
        }
        
        
        
    }
}
