<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Cart;
use backend\models\Course;
use backend\models\Coupon;

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
        $product_id = $data['product_id'];
        
        $is_exist = Cart::find()
        ->where(['product_id' => $product_id])
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
        $product_id = explode(',', $post['product_id']);
        $this->findModel($product_id)->delete();
        
        $data['status'] = 'success';
        $data['code'] = 0;
        $data['message'] = '删除成功';
        return json_encode($data);
    }
    
    public function actionShopping()
    {
        $post = Yii::$app->request->Post();
        $course_type = $post['course_type'];
        $course_ids = explode(',', $post['course_ids']);
        $models = Course::find()
        ->where(['id' => $course_ids])
        ->andWhere(['onuse' => 1])
        ->all();
        $courseids = '';
        foreach($models as $model) {
            $courseids .= $model->id . ',';
        }
        $coupons = Coupon::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['isuse' => 0])
        ->andWhere(['>', 'end_time', date('Y-m-d H:i:s', time())])
        ->all();        
        return $this->render('shopping', ['models' => $models, 'course_type' => $course_type, 'course_ids' => $courseids, 'coupons' => $coupons]);
    }
    
    protected function findModel($product_id)
    {
        $model = Cart::find()
        ->where(['product_id' => $product_id])
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->one();
        if (($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
