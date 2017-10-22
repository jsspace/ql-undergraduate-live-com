<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Cart;
use backend\models\Course;
use backend\models\Coupon;
use backend\models\CoursePackage;

class CartController extends \yii\web\Controller
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
        $sql = 'select cart_id, {{%course}}.id as course_id, course_name, list_pic, price, discount, username as teacher_name ';
        $sql .= 'from {{%cart}} inner join {{%course}} inner join  {{%user}}';
        $sql .= 'on {{%cart}}.product_id = {{%course}}.id and {{%cart}}.user_id = '.Yii::$app->user->id;
        $sql .= ' and {{%course}}.teacher_id = {{%user}}.id order by {{%cart}}.created_at desc';
        $models = Yii::$app->db->createCommand($sql)
        ->queryAll();
        return $this->render('index', ['models' => $models]);
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
        $this->findModel($cart_id)->delete();
        
        $data['status'] = 'success';
        $data['code'] = 0;
        $data['message'] = '删除成功';
        return json_encode($data);
    }
    
    public function actionShopping()
    {
        $post = Yii::$app->request->Post();
        $course_package_ids = explode(',', $post['course_package_ids']);
        $course_ids = explode(',', $post['course_ids']);
        $course_models = Course::find()
        ->where(['id' => $course_ids])
        ->andWhere(['onuse' => 1])
        ->all();
        $course_ids = '';
        foreach($course_models as $model) {
            $course_ids .= $model->id . ',';
        }
        $course_package_models = CoursePackage::find()
        ->where(['id' => $course_package_ids])
        ->andWhere(['onuse' => 1])
        ->all();
        $course_package_ids = '';
        foreach($course_package_models as $model) {
            $course_package_ids .= $model->id . ',';
        }
        $coupons = Coupon::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['isuse' => 0])
        ->andWhere(['>', 'end_time', date('Y-m-d H:i:s', time())])
        ->all();        
        return $this->render('shopping', [
            'course_models' => $course_models,
            'course_ids' => $course_ids,
            'course_package_models' => $course_package_models,
            'course_package_ids' => $course_package_ids,
            'coupons' => $coupons]);
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
}
