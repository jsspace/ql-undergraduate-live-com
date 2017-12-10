<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\CourseCategory;
use backend\models\Course;
use backend\models\CourseChapter;
use backend\models\CourseSection;
use backend\models\CourseComent;
use backend\models\Data;
use backend\models\Quas;
use Qiniu\Auth;
use Yii;

class CourseController extends Controller
{
        /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['qvaluate', 'ques'],
                'rules' => [
                    [
                        'actions' => ['qvaluate', 'ques'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'qvaluate' => ['post'],
                    'ques' => ['post'],
                ],
            ],
        ];
    }
    
    
    public function actionList()
    {
        $catModels = CourseCategory::find()
        ->all();
        
        $coursemodels = Course::find()
        ->where(['onuse' => 1])
        ->all();

        $firArr = array();

        foreach ($catModels as $catModelKey => $catModel) {
            if ($catModel->parent_id == 0) {
                $firArr[$catModelKey] = array();
                $firArr[$catModelKey]['firModel'] = $catModel;
                $firArr[$catModelKey]['child'] = array();
                foreach ($catModels as $subModelKey => $subModel) {
                    if ($subModel->parent_id == $catModel->id) {
                        $firArr[$catModelKey]['child'][$subModelKey] = array();
                        $firArr[$catModelKey]['child'][$subModelKey]['submodel'] = $subModel;
                        $firArr[$catModelKey]['child'][$subModelKey]['course'] = array();
                        foreach ($coursemodels as $coursekey => $coursemodel) {
                            if(in_array($subModel->id, explode(',', $coursemodel->category_name)))
                            {
                                $firArr[$catModelKey]['child'][$subModelKey]['course'][$coursekey] = $coursemodel;
                            }
                        }
                    }
                }
            }
        }
        return $this->render('list', ['courseLists' => $firArr]);
    }

    public function actionSearch()
    {
        $searchContent = Yii::$app->request->get('searchContent');
        $coursemodels = Course::find()
        ->where(['like', 'course_name', $searchContent])
        ->all();
        return $this->render('search', ['coursemodels' => $coursemodels]);
    }
    
    public function actionDetail()
    {
        $courseid = Yii::$app->request->get('courseid');
        $courseModel = Course::find()
        ->where(['id' => $courseid])
        ->one();
        //浏览次数加1
        $courseModel->view = $courseModel->view+1;
        $courseModel->save();
        $courseDetail = array();
        $courseDetail['course'] = $courseModel;
        $courseDetail['coursechild'] = array();
        $chapters = CourseChapter::find()
        ->where(['course_id' => $courseid])
        ->all();
        $sections = CourseSection::find()
        ->all();
        $duration = 0;
        foreach ($chapters as $chapterKey => $chapter) {
            $courseDetail['coursechild'][$chapterKey]['chapter'] = $chapter;
            $courseDetail['coursechild'][$chapterKey]['chapterchild'] = array();
            foreach ($sections as $sectionsKey => $section) {
                if ($section->chapter_id == $chapter->id) {
                    $courseDetail['coursechild'][$chapterKey]['chapterchild'][$sectionsKey] = $section;
                }
                $duration = $duration+$section->duration;
            }
        }
        // 课程评价
        $course_comments = CourseComent::find()
        ->where(['course_id' => $courseid])
        ->andWhere(['check' => 1])
        ->all();
        //课程资料
        $datas = Data::find()
        ->where(['course_id' => $courseid])
        ->all();
        /* 教师答疑 */
        $quas = Quas::find()
        ->where(['course_id' => $courseid])
        ->andWhere(['check' => 1])
        ->all();
        return $this->render('detail', ['courseDetail' => $courseDetail, 'duration' => $duration, 'course_comments' => $course_comments, 'datas' => $datas, 'quas' => $quas]);
    }

    public function actionEvaluate()
    {
        $data = Yii::$app->request->Post();
        $courseid = $data['course_id'];
        $content = $data['content'];
        $course_comment = new CourseComent();
        $course_comment->course_id = $courseid;
        $course_comment->content = $content;
        $course_comment->user_id = Yii::$app->user->id;
        $result = $course_comment->save();
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = '提交成功,等待审核！';
        } else {
            $data['status'] = 'error';
            $data['message'] = '提交失败';
        }
        return json_encode($data);
    }

    public function actionQues()
    {
        $data = Yii::$app->request->Post();
        $courseid = $data['course_id'];
        $content = $data['content'];
        $course_quas = new Quas();
        $course_quas->course_id = $courseid;
        $course_quas->question = $content;
        $course_quas->student_id = Yii::$app->user->id;
        $course_quas->question_time = time();
        $course_quas->check = 0;
        $result = $course_quas->save();
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = '问题提交成功,等待审核！';
        } else {
            $data['status'] = 'error';
            $data['message'] = '提交失败';
        }
        return json_encode($data);
    }
    public function actionCheck()
    {
        if (Yii::$app->user->isGuest) {
            $data['status'] = 0;
            $data['message'] = '请先登陆再观看课程';
            return json_encode($data);
        }
        $data = Yii::$app->request->Post();
        $section_id = $data['section_id'];
        $course_id = $data['course_id'];
        $section = CourseSection::find()
        ->where(['id' => $section_id])
        ->one();
        if (!empty($section)) {
            if ($section->paid_free == 0) {
                $data['status'] = 1;
                $data['message'] = '正在请求观看免费课程';
                $data['url'] = $section->video_url;
                return json_encode($data);
            } else {
                $auth = new Auth('BpA5RUTf1eWdiDpsRrosEJ-i9CroZjj9Gi4NOw5t', 'errjOOqxbwghY96t1a4bSP-ERR-42bHqEI_4H-15');
                $video_url = $auth->privateDownloadUrl($section->video_url, $expires = 3600);
                $is_member = Course::ismember($course_id);/*判断是否是该分类下的会员*/
                if ($is_member == 1) {
                    $data['status'] = '4';
                    $data['message'] = '会员，允许观看';
                    $data['url'] = $video_url;
                    return json_encode($data);
                }
                $ispay = Course::ispay($course_id);/*判断是否已经购买*/
                if ($ispay == 1) {
                    $data['status'] = '2';
                    $data['message'] = '用户已经购买了该课程，允许观看';
                    $data['url'] = $video_url;
                } else {
                    $data['status'] = '3';
                    $data['message'] = '您尚未购买该课程，请先购买后再观看';
                    $data['url'] = '';
                }
                return json_encode($data);
            }
        }
    }
}
