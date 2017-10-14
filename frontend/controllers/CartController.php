<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Cart;

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
                        'actions' => ['index'],
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
        $sql = 'select cart_id, id, course_name, list_pic, price, discount ';
        $sql .= 'from {{%cart}} inner join {{%course}} ';
        $sql .= 'on {{%cart}}.course_id = {{%course}}.id and {{%cart}}.user_id = '.Yii::$app->user->id;
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
        $course_id = $data['course_id'];
        
        $is_exist = $this->findModel($course_id);
        if (!empty($is_exist)) {
            $data['status'] = 'error';
            $data['code'] = 3;
            $data['message'] = '购物车中已经有此课程';
            return json_encode($data);
        }
        
        $cart = new Cart();
        $cart->user_id = Yii::$app->user->id;
        $cart->course_id = $course_id;
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
        $course_id = $post['course_id'];
        $this->findModel($course_id)->delete();
        
        $data['status'] = 'success';
        $data['code'] = 0;
        $data['message'] = '删除成功';
        return json_encode($data);
    }
    
    protected function findModel($course_id)
    {
        $model = Cart::find(['course_id' => $course_id])
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->one();
        if (($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
