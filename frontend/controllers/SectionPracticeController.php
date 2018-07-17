<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Course;
use backend\models\CourseSection;
use backend\models\User;
use Yii;


class SectionPracticeController extends Controller
{
        /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['qvaluate', 'ques'],
                'rules' => [
                    [
                        'actions' => ['qvaluate', 'ques'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'qvaluate' => ['post'],
                    'ques' => ['post'],
                ],
            ],
        ];
    }
    
    
    public function actionList()
    {
        $courses = Course::find()
        ->where(['onuse' => 1])
        ->andWhere(['type' => 1])
        ->with('courseSections')
        ->orderBy('create_time desc');
        $pages = new Pagination(['totalCount' => $courses->count(), 'pageSize' => '5']);
        $models = $courses->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        return $this->render('list', ['courses' => $models, 'pages' => $pages]);
    }

}
