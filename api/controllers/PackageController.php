<?php

namespace api\controllers;

use yii\web\Controller;
use backend\models\CoursePackage;
use Yii;
use backend\models\Course;
use backend\models\User;


class PackageController extends Controller
{
    // 套餐列表页
    public function actionList()
    {
        $packagemodels = CoursePackage::find()
        ->where(['onuse' => 1])
        ->orderBy('position asc')
        ->all();
        $packages = array();
        foreach ($packagemodels as $key => $package) {
            $content = array(
                'id' => $package->id,
                'name' => $package->name,
                'price' => $package->discount,
                'online' => $package->online,
            );
            $course_arr = array_filter(explode(',', $package->course));
            $content['course_num'] = count($course_arr);
            $courses = Course::find()
            ->where(['onuse' => 1])
            ->andWhere(['id' => $course_arr])
            ->all();
            $teachers = array();
            $teacher_str = '';
            foreach ($courses as $key => $course) {
                $teacher_str = $teacher_str .','. $course->teacher_id;
            }
            $teacher_arr = array_unique(array_filter(explode(',', $teacher_str)));
            foreach ($teacher_arr as $key => $teacher) {
                $user = User::find()
                ->where(['id' => $teacher])
                ->one();
                if(!empty($user)) {
                    $model = array(
                        'id' => $user->id,
                        'name' => $user->username,
                        'pic' => $user->picture
                    );
                    $teachers[] = $model;
                }
            }
            $content['teacher'] = $teachers;
            $packages[] = $content;
        }
        $lists = array();
        $lists['packages'] = $packages;
        $lists['status'] = 0;
        return json_encode($lists);
    }
    
    // 套餐详情页
    public function actionDetail()
    {
        $access_token = Yii::$app->request->get('access-token');
        $packageid = Yii::$app->request->get('pid');
        $user = \common\models\User::findIdentityByAccessToken($access_token);
        $packageModel = CoursePackage::find()
        ->where(['id' => $packageid])
        ->asArray()
        ->one();

        $isPay = 0;
        $packageDetail = array();
        $packageDetail['package'] = $packageModel;
        $packageDetail['course'] = array();
        $courseids = array_filter(explode(',', $packageModel['course']));
        foreach ($courseids as $courseid) {
            $course = Course::find()
            ->where(['id' => $courseid])
            ->one();
            if (!empty($user)) {
                $isPay = Course::ispay($courseid, $user->id);
            }
            $chapters = $course->courseChapters;
            $classrooms = 0; //课堂学
            foreach ($chapters as $key => $chapter) {
                $sections = $chapter->courseSections;
                foreach ($sections as $key => $section) {
                    $points = $section->courseSectionPoints;
                    $classrooms += count($points);
                }
            }
            $content = array(
                'id' => $course->id,
                'name' => $course->course_name,
                'pic' => $course->list_pic,
                'discount' => $course->discount,
                'classrooms' => $classrooms
            );
            $packageDetail['course'][] = $content;
        }
        $packageDetail['status'] = 0;
        $packageDetail['ispay'] = $isPay;
        return json_encode($packageDetail);
    }
}
