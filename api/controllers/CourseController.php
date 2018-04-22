<?php

namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use backend\models\Course;
use backend\models\CourseCategory;
use backend\models\User;
use backend\models\CourseChapter;
use backend\models\CourseSection;
use backend\models\CourseComent;
use backend\models\Data;
use backend\models\Quas;
use backend\models\UserStudyLog;
use Qiniu\Auth;

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
        $college_intro = array(
            'des' => $catModel->des,
            'name' => $catModel->name
        );
        $collegeArr['college_intro'] = $college_intro;
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
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = \common\models\User::findIdentityByAccessToken($access_token);
        $courseid = $data['courseid'];
        $invite = 0;
        if (isset($data['invite'])) {
            $invite = $data['invite'];
        }
        //设置邀请人cookie
        $cookies = Yii::$app->response->cookies;
        if (!isset($cookies['invite']) || ($invite > 0)) {
            $cookies->add(new \yii\web\Cookie([
                'name' => 'invite',
                'value' => $invite,
                'expire'=>time()+3600*24*365
            ]));
        }
        $courseModel = Course::find()
        ->where(['id' => $courseid])
        ->one();
        //浏览次数加1
        $courseModel->view = $courseModel->view+1;
        $courseModel->save();
        $courseDetail = array();
        $chapters = CourseChapter::find()
        ->where(['course_id' => $courseid])
        ->all();
        $sections = CourseSection::find()
        ->all();
        $duration = 0;
        foreach ($chapters as $chapterKey => $chapter) {
            $content['chapter_name'] = $chapter->name;
            foreach ($sections as $sectionsKey => $section) {
                if ($section->chapter_id == $chapter->id) {
                    $duration = $duration+$section->duration;
                    $videoType = self::getVideoType($section);
                    $section = array(
                        'section_id' => $section->id,
                        'name' => $section->name,
                        'video_type_text' => $videoType['text'],
                        'type' => $section->type,
                        'url' => $videoType['url'],
                        'duration' => $section->duration,
                    );
                    $content['section'][] = $section;
                }
            }
            $courseDetail['chapter'][] = $content;
        }
        /* 课程详情 */
        $ismember = 0;
        $ispay = 0;
        $isschool = 0;
        if (!empty($user)) {
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('school',$roles_array)) {
                $isschool = 1;
            }
            $ismember = Course::ismember($courseModel->id, $user->id);
            $ispay = Course::ispay($courseModel->id, $user->id);
        }
        if ($courseModel->discount == 0) {
            $tag = 1; //公开课程
        } else if ($ismember == 1) {
            $tag = 2; //会员课程
        } else if ($ispay == 1 || $isschool == 1) {
            $tag = 3; //已购买课程
        } else {
            $tag = 0; //尚未购买
        }
        $course = array(
            'id' => $courseModel->id,
            'course_name' => $courseModel->course_name,
            'discount' => $courseModel->discount,
            'price' => $courseModel->price,
            'home_pic' => Url::to('@web'.$courseModel->home_pic, true),
            'teacher' => User::item($courseModel->teacher_id),
            'class' => $duration/60,
            'view' => $courseModel->view,
            'collection' => $courseModel->collection,
            'online' => $courseModel->online,
            'intro' => $courseModel->des,
            'ispay' => $tag
        );
        $courseDetail['course'] = $course;
        //课程教师
        $teacher_model = User::getUserModel($courseModel->teacher_id);
        $teacher = array(
            'teacher_img' => Url::to('@web'.$teacher_model->picture, true),
            'teacher_name' => $teacher_model->username,
            'teacher_tag' => $teacher_model->description,
            'office' => $teacher_model->office,
            'unit' => $teacher_model->unit,
            'goodat' => $teacher_model->goodat
        );
        $courseDetail['teacher'] = $teacher;
        // 课程评价
        /*$course_comments = CourseComent::find()
        ->where(['course_id' => $courseid])
        ->andWhere(['check' => 1])
        ->orderBy('id desc')
        ->all();
        foreach ($course_comments as $key => $course_comment) {
            $content = array(
                'user_img' => Url::to('@web'.User::getUserModel($course_comment->user_id)->picture, true),
                'user_name' => User::item($course_comment->user_id),
                'content' => $course_comment->content,
                'create_time' => date('Y-m-d H:i:s', $course_comment->create_time)
            );
            $courseDetail['course_comments'][] = $content;
        }*/
        //课程资料
        /*$datas = Data::find()
        ->where(['course_id' => $courseid])
        ->orderBy('id desc')
        ->all();
        foreach ($datas as $key => $data) {
            if ($data->url_type == 1) {
                $url = Url::to(['data/detail', 'dataid' => $data->id]);
            } else {
                $url = strip_tags($data->content);
            }
            $content = array(
                'url' => $url,
                'name' => $data->name,
                'summary' => $data->summary
            );
            $courseDetail['course_tasks'][] = $content;
        }*/
        /* 教师答疑 */
        /*$quas = Quas::find()
        ->where(['course_id' => $courseid])
        ->orderBy('id desc')
        ->andWhere(['check' => 1])
        ->all();
        foreach ($quas as $key => $qua) {
            $content = array(
                'question' => $qua->question,
                'question_time' => date('Y-m-d H:i:s', $qua->question_time),
                'answer' => $qua->answer,
                'answer_time' => date('Y-m-d H:i:s', $qua->answer_time)
            );
            $courseDetail['course_quas'][] = $content;
        }*/
        /* 获取前12个学员 */
        $studyids = UserStudyLog::find()
        ->select('userid')
        ->where(['courseid' => $courseid])
        ->orderBy('start_time desc')
        ->limit(12)
        ->asArray()
        ->all();
        if (!empty($studyids)) {
            $studyids = array_column($studyids, 'userid');
            $studyids = array_unique($studyids);
            foreach ($studyids as $key => $studyid) {
                $content = array(
                    'student_img' => Url::to('@web'.User::getUserModel($studyid)->picture, true),
                    'student_name' => User::item($studyid)
                );
                $courseDetail['students'][] = $content;
            }
        }
        return  json_encode($courseDetail);
    }
    public static function getVideoType($section)
    {
        $text = '';
        $current_time = date('Y-m-d H:i:s');
        $end_time = date('Y-m-d H:i:s',strtotime($section->start_time."+".$section->duration." minute"));
        //0 直播 2 直播答疑
        $video_url = $section->video_url;
        if ($section->type == 0 || $section->type == 2) {
            if ($current_time < $section->start_time) {
                $text = '最近直播：'.$section->start_time;
            } else if ($current_time >= $section->start_time && $current_time < $end_time) {
                 $text = '直播中';
            } else if ($current_time > $end_time) {
                $text = '直播回放';
            }
        } else if ($section->type == 1) {
            $text = '点播课程';
        }
        $url = '';
        if ($section->type == 0 || $section->type == 2) {
            $url = $section->video_url;
        }
        $result = array(
            'text' => $text,
            'url' => $url
        );
        return $result;
    }
    public function actionCheck()
    {
        $get = Yii::$app->request->get();
        $access_token = $get['access-token'];
        $user = \common\models\User::findIdentityByAccessToken($access_token);
        if (empty($user)) {
            $result = array(
                'status' => 0,
                'message' => '请先登陆再观看课程'
            );
            return json_encode($result);
        }
        $data = Yii::$app->request->post();
        $section_id = $data['section_id'];
        $course_id = $data['course_id'];
        $section = CourseSection::find()
        ->where(['id' => $section_id])
        ->one();
        if (!empty($section)) {
            if ($section->paid_free == 0) {
                $result = array(
                    'status' => 1,
                    'message' => '正在请求观看免费课程',
                    'url' => $section->video_url
                );
                return json_encode($result);
            } else {
                $auth = new Auth(Yii::$app->params['access_key'], Yii::$app->params['secret_key']);
                $video_url = $auth->privateDownloadUrl($section->video_url, $expires = 3600);
                $is_member = Course::ismember($course_id, $user->id);/*判断是否是该分类下的会员*/
                if ($is_member == 1) {
                    $result = array(
                        'status' => 4,
                        'message' => '会员，允许观看',
                        'url' => $video_url
                    );
                    return json_encode($result);
                }
                $ispay = Course::ispay($course_id, $user->id);/*判断是否已经购买*/
                $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
                $isschool = 0;
                if (array_key_exists('school',$roles_array)) {
                    $isschool = 1;
                }
                if ($ispay == 1 || $isschool == 1) {
                    $result = array(
                        'status' => 2,
                        'message' => '用户已经购买了该课程，允许观看',
                        'url' => $video_url
                    );
                } else {
                    $result = array(
                        'status' => 3,
                        'message' => '您尚未购买该课程，请先购买后再观看',
                        'url' => ''
                    );
                }
                return json_encode($result);
            }
        }
    }
}
