<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Cart;
use backend\models\Course;
use backend\models\Coupon;
use backend\models\Coin;
use backend\models\CoursePackage;

class CartController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index', 'shopping'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['post'],
                    'remove' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $sql = 'select cart_id, {{%course}}.id as course_id, course_name, list_pic, price, discount, username as teacher_name';
        $sql .= ' from ({{%cart}} inner join {{%course}}';
        $sql .= ' on {{%cart}}.user_id = '.Yii::$app->user->id.' and {{%cart}}.type = "course" and {{%cart}}.product_id = {{%course}}.id)  inner join  {{%user}}';
        $sql .= ' on {{%course}}.teacher_id = {{%user}}.id order by {{%cart}}.created_at desc';
        $course_models = Yii::$app->db->createCommand($sql)
        ->queryAll();
        /*$sql = 'select cart_id, {{%course_package}}.id as course_package_id, {{%course_package}}.name as course_name, list_pic, price, discount, username as teacher_name';
        $sql .= ' from ({{%cart}} inner join {{%course_package}}';
        $sql .= ' on {{%cart}}.user_id = '.Yii::$app->user->id .' and {{%cart}}.product_id = {{%course_package}}.id ';
        $sql .= ' and {{%cart}}.type = "course_package") inner join {{%user}} ';
        $sql .= ' on {{%course_package}}.head_teacher = {{%user}}.id order by {{%cart}}.created_at desc';
        $course_package_models = Yii::$app->db->createCommand($sql)
        ->queryAll();*/
        return $this->render('index', ['course_models' => $course_models/*, 'course_package_models' => $course_package_models,*/]);
    }
    
    public function actionAdd()
    {
        if(Yii::$app->user->isGuest) {
            $data['status'] = 'error';
            $data['code'] = 2;
            $data['message'] = '请登录后再操作';
            return json_encode($data);
        }
        $data = Yii::$app->request->Post();
        $type = $data['type'];
        $product_id = $data['product_id'];
        
        $is_exist = Cart::find()
        ->where(['type' => $type])
        ->andWhere(['product_id' => $product_id])
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->one();
        if (!empty($is_exist)) {
            $data['status'] = 'error';
            $data['code'] = 3;
            $data['message'] = '购物车中已经有此课程';
            return json_encode($data);
        }
        
        $cart = new Cart();
        $cart->user_id = Yii::$app->user->id;
        $cart->type = $type;
        $cart->product_id = $product_id;
        $cart->created_at = time();
        $result = $cart->save();
        if ($result) {
            $data['status'] = 'success';
            $data['code'] = 0;
            $data['message'] = '添加成功';
        } else {
            $data['status'] = 'error';
            $data['code'] = 1;
            $data['message'] = '添加失败';
        }
        return json_encode($data);
    }

    public function actionRemove()
    {
        if(Yii::$app->user->isGuest) {
            $data['status'] = 'error';
            $data['code'] = 2;
            $data['message'] = '请登录后再操作';
            return json_encode($data);
        }
        $post = Yii::$app->request->Post();
        $cart_id = explode(',', $post['cart_id']);
        Cart::deleteAll(['cart_id' => $cart_id]);
        
        $data['status'] = 'success';
        $data['code'] = 0;
        $data['message'] = '删除成功';
        return json_encode($data);
    }
    
    public function actionShopping()
    {
        $post = Yii::$app->request->Post();
        
        //唯一订单号码（KB-YYYYMMDDHHIISSNNNNNNNNCC）
        $order_sn = $this->createOrderid();
        
        //$course_package_ids = explode(',', $post['course_package_ids']);
        $course_ids = explode(',', $post['course_ids']);
        $course_models = Course::find()
        ->where(['id' => $course_ids])
        ->andWhere(['onuse' => 1])
        ->all();
        $course_ids = '';
        foreach($course_models as $model) {
            $course_ids .= $model->id . ',';
        }
        /*$course_package_models = CoursePackage::find()
        ->where(['id' => $course_package_ids])
        ->andWhere(['onuse' => 1])
        ->all();
        $course_package_ids = '';
        foreach($course_package_models as $model) {
            $course_package_ids .= $model->id . ',';
        }*/
        $coupons = Coupon::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['isuse' => 0])
        ->andWhere(['>', 'end_time', date('Y-m-d H:i:s', time())])
        ->all();

        /*金币余额*/
        /*$coin = Coin::find()
        ->where(['userid' => Yii::$app->user->id])
        ->orderBy('id desc')
        ->one();
        if (!empty($coin)) {
            $balance = $coin->balance;
        } else {
            $balance = 0;
        }*/
        return $this->render('shopping', [
            'course_models' => $course_models,
            'order_sn' => $order_sn,
            'course_ids' => $course_ids,
            //'course_package_models' => $course_package_models,
            //'course_package_ids' => $course_package_ids,
            'coupons' => $coupons,
            //'coin_balance' => $balance
        ]);
    }
    
    protected function findModel($cart_id)
    {
        $model = Cart::find()
        ->where(['cart_id' => $cart_id])
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->one();
        if (($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public static function createOrderid()
    {
        //生成24位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-CC，其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数，CC=检查码
        //订购日期
        $order_date = date('Y-m-d');
        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
        $order_id_main = date('YmdHis') . rand(10000000,99999999);
        //订单号码主体长度
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for($i=0; $i<$order_id_len; $i++){
            $order_id_sum += (int)(substr($order_id_main,$i,1));
        }
        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
        $order_sn = 'KB-' . $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);
        return $order_sn;
    }
}
