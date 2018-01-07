<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use backend\models\Command;
use yii\data\Pagination;

class CommandController extends Controller
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
        $commands = Command::find()
        ->orderBy('create_time desc');
        //->all();
        $pages = new Pagination(['totalCount' => $commands->count()]);
        $models = $commands->offset($pages->offset)
        //->limit(2)
        ->all();
        return $this->render('index', ['commands' => $models, 'pages' => $pages]);
    }

    public function actionAdd()
    {
        if(Yii::$app->user->isGuest) {
            $result['status'] = '0';
            $result['message'] = '请登录后再操作';
            return json_encode($result);
        }
        $data = Yii::$app->request->Post();
        $content = $data['content'];
        $user_id = Yii::$app->user->id;
        $model = new Command();
        $model->user_id = $user_id;
        $model->content = $content;
        $model->create_time = time();
        if ($model->save()) {
            $result['status'] = '1';
            $result['message'] = '您的需求已成功提交';
        } else {
            $result['status'] = '2';
            $result['message'] = '发表失败';
        }
        return json_encode($result);
    }
}
