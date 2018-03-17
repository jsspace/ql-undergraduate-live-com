<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use backend\models\Comment;
use yii\data\Pagination;

class CommentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'checker' => [
                'class' => 'backend\libs\CheckerFilter',
            ],
//             'cache' => [
//                 'class' => 'yii\filters\PageCache',
//                 'duration' => 60,
//                 'variations' => [
//                     \Yii::$app->language,
//                 ],
//             ],
        ];
    }
    
    
    public function actionIndex()
    {
        $comments = Comment::find()
        ->where(['check' => 1])
        ->orderBy('create_time desc');
        $pages = new Pagination(['totalCount' => $comments->count()]);
        $models = $comments->offset($pages->offset)
        //->limit(2)
        ->all();
        return $this->render('index', ['comments' => $models, 'pages' => $pages]);
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
        $model = new Comment();
        $model->user_id = $user_id;
        $model->content = $content;
        $model->create_time = time();
        if ($model->save()) {
            $result['status'] = '1';
            $result['message'] = '发表成功';
        } else {
            $result['status'] = '2';
            $result['message'] = '发表失败';
        }
        return json_encode($result);
    }
}
