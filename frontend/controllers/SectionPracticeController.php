<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Course;
use backend\models\CourseSection;
use backend\models\User;
use backend\models\SectionPractice;
use Yii;
use Qiniu\Auth;

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
                'rules' => [
                    [
                        'actions' => ['get-practice', 'get-explain'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-practice' => ['post'],
                ],
            ],
        ];
    }

    public function actionGetPractice()
    {
        $data = Yii::$app->request->Post();
        $courseid = $data['courseId'];
        $sectionid = $data['sectionId'];
        $userid = Yii::$app->user->id;
        $ispay = Course::ispay($courseid, $userid);
        if ($ispay == 1) {
            $data['status'] = '2';
            $practices = SectionPractice::find()
            ->where(['course_id' => $courseid])
            ->andWhere(['section_id' => $sectionid])
            ->asArray()
            ->all();
            foreach ($practices as $key => $practice) {
                $practices[$key]['create_time'] = date('Y-m-d H:i:s', $practice['create_time']);
            }
            $data['practices'] = $practices;
        } else {
            $data['status'] = '3';
            $data['message'] = '您尚未购买该课程，请先购买后再查看';
        }
        return json_encode($data);
    }
    public function actionGetExplain()
    {
        $data = Yii::$app->request->Post();
        $courseid = $data['courseId'];
        $sectionid = $data['sectionId'];
        $userid = Yii::$app->user->id;
        $ispay = Course::ispay($courseid, $userid);
        if ($ispay == 1) {
            $data['status'] = '2';
            $section = CourseSection::find()
            ->where(['course_id' => $courseid])
            ->andWhere(['id' => $sectionid])
            ->one();
            $auth = new Auth(Yii::$app->params['access_key'], Yii::$app->params['secret_key']);
            $video_url = $auth->privateDownloadUrl($section->explain_video_url, $expires = 3600);
            $data['url'] = $video_url;
        } else {
            $data['status'] = '3';
            $data['message'] = '您尚未购买该课程，请先购买后再查看';
        }
        return json_encode($data);
    }
}
