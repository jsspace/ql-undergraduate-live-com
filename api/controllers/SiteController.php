<?php

namespace api\controllers;

use yii;
use yii\web\Controller;
use backend\models\Ad;
use backend\models\CourseCategory;
use backend\models\Course;
use common\models\User;
use yii\helpers\Url;
use backend\models\Notice;
use backend\models\UserStudyLog;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        /* 广告位 */
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

        // 最近在学
        $get = Yii::$app->request->get();
        if (isset($get['access-token'])) {
            $access_token = $get['access-token'];
            $user = User::findIdentityByAccessToken($access_token);
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
                $result['course'] = array(
                    'id' => $course->id,
                    'pic' => $course->list_pic,
                    'name' => $course->course_name,
                    'intro' => $course->intro
                );
            }
        }

        return json_encode($result);
    }
}
