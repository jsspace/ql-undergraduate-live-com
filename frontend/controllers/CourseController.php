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
                            if(strstr($coursemodel->category_name, $subModel->name) != false)
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
}
