<?php

namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use backend\models\Course;
use backend\models\CourseCategory;
use backend\models\User;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class CourseController extends Controller
{
    /**
     * @inheritdoc
     */

    public function actionCollege()
    {
        $cat = Yii::$app->request->get('cat');
        $catModel = CourseCategory::find()
        ->where(['id' => $cat])
        ->one();
        $coursemodels = Course::find()
        ->where(['onuse' => 1])
        ->all();
        // $classes = CoursePackage::find()
        // ->where(['onuse' => 1])
        // ->all();
        $collegeArr = array();
        $collegeArr['college_intro'] = $catModel->des;
        $teachers = array();
        foreach ($coursemodels as $key => $coursemodel) {
            $categoryids = explode(',', $coursemodel->category_name);
            if (in_array($catModel->id, $categoryids)) {
                $content = array(
                    'id' => $coursemodel->id,
                    'course_name' => $coursemodel->course_name,
                    'list_pic' => Url::to('@web'.$coursemodel->list_pic, true),
                    'discount' => $coursemodel->discount,
                    'online' => $coursemodel->online
                );
                $collegeArr['college_course'][] = $content;
                $teachers[] = $coursemodel->teacher_id;
            }
        }
        if (!empty($teachers)) {
            $teachers = array_unique($teachers);
            $collegeArr["college_teacher"] = array();
            foreach ($teachers as $key => $teacher) {
                $teacher = User::getUserModel($teacher);
                $content = array(
                    'id' => $teacher->id,
                    'username' => $teacher->username,
                    'office' => $teacher->office,
                    'unit' => $teacher->unit,
                    'goodat' => $teacher->goodat,
                    'picture' => Url::to('@web'.$teacher->picture, true)
                );
                $collegeArr["college_teacher"][] = $content;
            }
        }
        return json_encode($collegeArr);
    }
    public function actionList()
    {
        $courses = Course::find()
        ->where(['onuse' => 1])
        ->orderBy('create_time desc')
        ->all();
        $result = array();
        foreach ($courses as $key => $course) {
            $content = array(
                'id' => $course->id,
                'course_name' => $course->course_name,
                'list_pic' => Url::to('@web'.$course->list_pic, true),
                'discount' => $course->discount,
                'online' => $course->online
            );
            $result[] = $content;
        }
        return json_encode($result);
    }
    public function actionDetail()
    {

    }
}
