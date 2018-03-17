<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\CourseNews;
use backend\models\Course;

class CourseNewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
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
    }
    
    
    public function actionList()
    {
        $tjcourses = CourseNews::find()
        ->orderBy('position asc')
        ->where(['onuse' => 1])
        ->all();
        return $this->render('list', ['tjcourses' => $tjcourses]);
    }

    public function actionDetail()
    {
        $tuiid = Yii::$app->request->get('newsid');
        $tui = CourseNews::find()
        ->where(['id' => $tuiid])
        ->one();
        $courses = Course::find()
        ->where(['id' => $tui->courseid])
        ->all();
        return $this->render('detail', ['tui' => $tui, 'courses' => $courses]);
    }

}
