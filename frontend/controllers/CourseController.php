<?php

namespace frontend\controllers;

use yii\web\Controller;
use backend\models\CourseCategory;
use backend\models\Course;
use backend\models\CourseChapter;
use backend\models\CourseSection;
use backend\models\CourseComent;
use Yii;

class CourseController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'cache' => [
                'class' => 'yii\filters\PageCache',
                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ],
            ],
        ];
    }*/
    
    
    public function actionList()
    {
        $catModels = CourseCategory::find()
        ->all();
        
        $coursemodels = Course::find()
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
        return $this->render('detail', ['courseDetail' => $courseDetail, 'duration' => $duration, 'course_comments' => $course_comments]);
    }

}
