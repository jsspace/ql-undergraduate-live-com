<?php

namespace api\controllers;

use yii;
use yii\web\Controller;
use backend\models\Ad;
use backend\models\CourseCategory;
use backend\models\Course;
use backend\models\User;
use yii\helpers\Url;
use backend\models\Notice;
use backend\models\UserStudyLog;
use backend\models\Information;
use backend\models\CoursePackage;
use backend\models\Book;
use common\service\JssdkService;
use Da\QrCode\QrCode;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        // 广告位
        $ads = Ad::find()
        ->where(['online' => 1])
        ->andWhere(['ismobile' => 1])
        ->orderBy('position')
        ->asArray()
        ->all();

        // 公告
        $notices = Notice::find()
        ->orderBy([
            'position' => SORT_ASC,
            'id' => SORT_DESC,
        ])
        ->asArray()
        ->all();

        $result = array(
            'ads' => $ads,
            'notices' => $notices
        );

        // 资讯
        $informations = Information::find()
        ->limit(2)
        ->orderBy('release_time desc')
        ->all();
        $information_arr = array();
        foreach ($informations as $key => $information) {
            $information_arr[] = array(
                'id' => $information->id,
                'title' => $information->title,
                'author' => $information->author,
                'release_time' => $information->release_time,
                'pic' =>  $information->cover_pic
            );
        }
        $result['information'] = $information_arr;

        // VIP套餐
        $packageModels = CoursePackage::find()
        ->where(['onuse' => 1])
        ->limit(2)
        ->orderBy('position asc')
        ->all();
        $packages = array();
        foreach ($packageModels as $key => $package) {
            $content = array(
                'id' => $package->id,
                'name' => $package->name,
                'price' => $package->discount,
                'online' => $package->online,
            );
            $course_arr = array_filter(explode(',', $package->course));
            $content['course_num'] = count($course_arr);
            $courses = Course::find()
            ->select('teacher_id')
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
                if (!empty($user)) {
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
        $result['packages'] = $packages;

        // 精品课程
        $coursesModels = Course::find()
        ->where(['type' => 1])
        ->andWhere(['onuse' => 1])
        ->with([
            'courseChapters' => function($query) {
                $query->with(['courseSections' => function($query) {
                    $query->with('courseSectionPoints');
                }]);
            }
        ])
        ->limit(2)
        ->orderBy('position asc')
        ->all();
        $courses = array();
        foreach ($coursesModels as $key => $course) {
            $id_arr = explode(',', $course->teacher_id);
            $teacher_name = '';
            foreach ($id_arr as $key => $id) {
                $teacher = User::getUserModel($id);
                if ($teacher) {
                    $teacher_name = $teacher->username.','.$teacher_name;
                }
            }
            // 去除最后一个逗号
            $teacher_name = substr($teacher_name, 0, strlen($teacher_name)-1);
            $classrooms = 0;
            $chapters = $course->courseChapters;
            foreach ($chapters as $key => $chapter) {
                $sections = $chapter->courseSections;
                foreach ($sections as $key => $section) {
                    $points = $section->courseSectionPoints;
                    $classrooms += count($points);
                }
            }
            $content = array(
                'id' => $course->id,
                'course_name' => $course->course_name,
                'list_pic' => $course->list_pic,
                'discount' => $course->discount,
                'online' => $course->online,
                'teacher' => $teacher_name,
                'classrooms' => $classrooms
            );
            $courses[] = $content;
        }
        $result['courses'] = $courses;

        // 升本公开课
        $openModels = Course::find()
        ->where(['onuse' => 1])
        ->andWhere(['type' => 2])
        ->limit(2)
        ->orderBy('create_time desc')
        ->all();
        $opens = array();
        foreach ($openModels as $key => $course) {
            $content = array(
                'id' => $course->id,
                'course_name' => $course->course_name,
                'list_pic' => $course->list_pic,
                'intro' => $course->intro,
                'duration' => $course->duration
            );
            $opens[] = $content;
        }
        $result['opens'] = $opens;

        // 推荐图书
        $books = Book::find()
        ->limit(2)
        ->orderBy("publish_time DESC")
        ->all();
        $book_arr = array();
        foreach ($books as $key => $book) {
            $book_arr[] = array(
                'id' => $book->id,
                'pic' => $book->pictrue,
                'name' => $book->name,
                'price' => $book->price,
                'order_price' => $book->order_price,
                'intro' => $book->intro
            );
        }
        $result['books'] = $book_arr;

        // 最近在学
        $get = Yii::$app->request->get();
        if (isset($get['access-token'])) {
            $access_token = $get['access-token'];
            $user = \common\models\User::findIdentityByAccessToken($access_token);
            if (!empty($user)) {
                $user_id = $user->id;
                $log = UserStudyLog::find()
                ->where(['userid' => $user_id])
                ->orderBy('start_time desc')
                ->one();
                $course_id = $log->courseid;
                $course = Course::find()
                ->where(['id' => $course_id])
                ->one();
                $result['recent'] = array(
                    'id' => $course->id,
                    'pic' => $course->list_pic,
                    'name' => $course->course_name,
                    'intro' => $course->intro
                );
            }
        }
        return json_encode(array(
            'status' => 0,
            'data' => $result
        ));
    }
    public function actionShareConfig() {
        $get = Yii::$app->request->get();
        $url = $get['url'];
        $config = Yii::$app->params;
        $jssdk = new JssdkService($config['yslwd_appid'], $config['yslwd_secret']);
        $signPackage = $jssdk->GetSignPackage($url);
        if ($signPackage) {
            $result = array (
                'status' => 0,
                'msg' => '成功获取微信分享配置项',
                'config' => $signPackage
            );
        } else {
            $result = array (
                'status' => -1,
                'msg' => '获取失败'
            );
        }
        return json_encode($result);
    }
    public function actionQrcode($url, $name)
    {
        $qrCode = (new QrCode($url))
        ->setSize(250)
        ->setMargin(5)
        ->useForegroundColor(51, 153, 255);
    
        // now we can display the qrcode in many ways
        // saving the result to a file:
        $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'] . 'qrcode_img/';
        $qrCode->writeFile($img_rootPath . $name); // writer defaults to PNG when none is specified
        echo self::base64EncodeImage($img_rootPath.$name);
        // display directly to the browser
        // header('Content-Type: '.$qrCode->getContentType());
        // echo $qrCode->writeString();
    }
}
