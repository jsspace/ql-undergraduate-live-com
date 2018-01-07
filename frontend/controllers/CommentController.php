<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use backend\models\Comment;


class CommentController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'cache' => [
                'class' => 'yii\filters\PageCache',
                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ],
            ],
        ];
    }*/
    
    
    public function actionIndex()
    {
        
        return $this->render('index');
    }
    public function actionAdd()
    {
        if(Yii::$app->user->isGuest) {
            $result['status'] = 'error';
            $result['message'] = '请登录后再操作';
            return json_encode($result);
        }
        $data = Yii::$app->request->Post();
        $content = $data['content'];
        $user_id = Yii::$app->user->id;
        $model = new Comment();
        $model->user_id = $user_id;
        $model->content = $content;
        $model->create_time = time();
        
    }
}
