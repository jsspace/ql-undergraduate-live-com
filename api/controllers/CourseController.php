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
        $data = Yii::$app->request->get();
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
        $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        $isschool = 0;
        if (array_key_exists('school',$roles_array)) {
            $isschool = 1;
        }
        $ismember = Course::ismember($courseModel->id);
        $ispay = Course::ispay($courseModel->id);
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
            'teacher' => User::item($courseModel->teacher_id),
            'class' => $duration/60,
            'view' => $courseModel->view,
            'collection' => $courseModel->collection,
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
        $studyids = array_column($studyids, 'userid');
        $studyids = array_unique($studyids);
        foreach ($studyids as $key => $studyid) {
            $content = array(
                'student_img' => Url::to('@web'.User::getUserModel($studyid)->picture, true),
                'student_name' => User::item($studyid)
            );
            $courseDetail['students'][] = $content;
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
}
