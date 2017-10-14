<?php

namespace frontend\controllers;

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
                'only' => ['index', 'add', 'remove'],
                'rules' => [
                    [
                        'actions' => ['index', 'add', 'remove'],
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
        $post = Yii::$app->request->Get();
        $course_id = $post['course_id'];
        
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
        $post = Yii::$app->request->Post();
        $course_id = $post['cart_id'];
        $this->findModel($course_id)->delete();
        
        $data['status'] = 'success';
        $data['code'] = 0;
        $data['message'] = '删除成功';
        return json_encode($data);
    }
    
    protected function findModel($cart_id)
    {
        $model = Cart::find(['cart_id' => $cart_id])
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->one();
        if (($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
