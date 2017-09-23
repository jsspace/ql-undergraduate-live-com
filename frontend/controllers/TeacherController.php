<?php

namespace frontend\controllers;

use yii\web\Controller;
use backend\models\User;
use backend\models\Course;
use Yii;

class TeacherController extends Controller
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
    
    public function actionList()
    {
        /*教师列表*/
        $teachers = User::getUserByrole('teacher');
        return $this->render('list',['teachers' => $teachers]);
    }
    
    public function actionDetail()
    {
        $userid = Yii::$app->request->get('userid');
        $teacher = User::getUserModel($userid);
        $courses = Course::find()
        ->where(['teacher_id' => $userid])
        ->all();
        return $this->render('detail',['teacher' => $teacher, 'courses' => $courses]);
    }

}
