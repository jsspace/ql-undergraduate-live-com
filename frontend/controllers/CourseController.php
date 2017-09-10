<?php

namespace frontend\controllers;

use yii\web\Controller;
use backend\models\CourseCategory;
use backend\models\Course;

class CourseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
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
    }
    
    
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
        return $this->render('list', ['courseList' => $firArr]);
    }
    
    public function actionDetail()
    {
        return $this->render('detail');
    }

}
