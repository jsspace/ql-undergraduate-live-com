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
                'img' => Url::to('@web'.$ad->img, true)
            );
            $ads_arr[] = $content;
        }
        $result['ads'] = $ads_arr;
        /*直属学院*/
        $colleges = CourseCategory::find()
        ->orderBy('position asc')
        ->all();
        $colleges_arr = array();
        foreach ($colleges as $key => $college) {
            $content = array(
                'id' => $college->id,
                'name' => $college->name,
                'icon' => Url::to('@web'.$college->list_icon, true)
            );
            $colleges_arr[] = $content;
        }
        $result['colleges'] = $colleges_arr;

        /*课程->热门推荐*/
        $hotcourses = Course::find()
        ->orderBy('view desc')
        ->limit(3)
        ->all();
        $hotcourses_arr = array();
        foreach ($hotcourses as $key => $hotcourse) {
            $content = array(
                'id' => $hotcourse->id,
                'course_name' => $hotcourse->course_name,
                'list_pic' => Url::to('@web'.$hotcourse->list_pic, true),
                'discount' => $hotcourse->discount,
                'online' => $hotcourse->online
            );
            $hotcourses_arr[] = $content;
        }
        $result['hotcourses'] = $hotcourses_arr;

        /*各大学院*/
        $collegeCourses = Course::find()
        ->orderBy('create_time desc')
        ->all();
        $course_cat = CourseCategory::find()
        ->select('id,name')
        ->orderBy('position asc')
        ->all();
        $collegeArr = array();
        foreach ($course_cat as $cat_key => $cat) {
            $college_content = array(
                'catid' => $cat->id,
                'college_name' => $cat->name
            );
            $count = 0;
            foreach ($collegeCourses as $key => $collegeCourse) {
                if ($count === 2) {
                    break;
                }
                if ($cat->id == $collegeCourse->category_name) {
                    $count = $count+1;
                    $content = array(
                        'id' => $hotcourse->id,
                        'course_name' => $collegeCourse->course_name,
                        'list_pic' => Url::to('@web'.$collegeCourse->list_pic, true),
                        'discount' => $collegeCourse->discount,
                        'online' => $collegeCourse->online
                    );
                    $college_content['college_course'][] = $content;
                }
            }
            if (!empty($college_content['college_course'])) {
                $collegeArr[] = $college_content;
            }
        }
        $result['college_course'] = $collegeArr;
        /*教师列表*/
        $teachers = User::getUserByrole('teacher');
        $teachers_arr = array();
        $tag = 0;
        foreach ($teachers as $key => $teacher) {
            if ($tag == 5) {
                break;
            }
            $content = array(
                'id' => $teacher->id,
                'username' => $teacher->username,
                'office' => $teacher->office,
                'unit' => $teacher->unit,
                'goodat' => $teacher->goodat,
                'picture' => Url::to('@web'.$teacher->picture, true),
            );
            $teachers_arr[] = $content;
            $tag++;
        }
        $result['teachers'] = $teachers_arr;
        return json_encode($result);
    }
}
