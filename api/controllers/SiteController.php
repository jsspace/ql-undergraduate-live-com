<?php

namespace api\controllers;

use yii;
use yii\web\Controller;
use backend\models\Ad;
use backend\models\CourseCategory;
use backend\models\Course;
use backend\models\User;
use yii\helpers\Url;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        $result = array();
        /* 广告位 */
        $ads = Ad::find()
        ->where(['online' => 1])
        ->andWhere(['ismobile' => 1])
        ->orderBy('position')
        ->all();
        $ads_arr = array();
        foreach ($ads as $key => $ad) {
            $content = array(
                'url' => $ad->url,
                'img' => $ad->img
            );
            $ads_arr[] = $content;
        }
        $result['home_ads'] = $ads_arr;

        /*课程->热门班级*/
        $hotcourses = Course::find()
        ->where(['type' => 1])
        ->andWhere(['onuse' => 1])
        ->with('courseSections')
        ->orderBy('create_time desc')
        ->limit(6)
        ->all();
        foreach ($hotcourses as $course) {
            $sections = $course->courseSections;
            $classrooms = 0; //课堂学
            $unit_test = 0; //单元测验
            foreach ($sections as $key => $section) {
                if ($section->type == 1) {
                    $classrooms++;
                } else if ($section->type == 0) {
                     $unit_test++;
                }
            }
        }
        $hotcourses_arr = array();
        foreach ($hotcourses as $key => $hotcourse) {
            $content = array(
                'id' => $hotcourse->id,
                'course_name' => $hotcourse->course_name,
                'list_pic' => $hotcourse->list_pic,
                'course_intro' => $hotcourse->intro,
                'classrooms' => $classrooms,
                'practices' => $classrooms,
                'unit_tests' => $unit_test,
                'examination_time' => $hotcourse->examination_time,
                'online' => $hotcourse->online
            );
            $hotcourses_arr[] = $content;
        }
        $result['class_courses'] = $hotcourses_arr;

        /*课程->公开课*/
        $opencourses = Course::find()
        ->where(['type' => 2])
        ->andWhere(['onuse' => 1])
        ->orderBy('create_time desc')
        ->limit(6)
        ->all();
        $opencourses_arr = array();
        foreach ($opencourses as $key => $opencourse) {
            $content = array(
                'id' => $opencourse->id,
                'course_name' => $opencourse->course_name,
                'list_pic' => $opencourse->list_pic,
                'discount' => $opencourse->discount,
                'create_time' => date('Y-m-d H:i:s', $opencourse->create_time),
                'teacher_id' => User::item($opencourse->teacher_id),
            );
            $opencourses_arr[] = $content;
        }
        $result['open_courses'] = $opencourses_arr;

        return json_encode($result);
    }
}
