<?php

namespace frontend\controllers;

use yii\web\Controller;
use backend\models\CourseCategory;

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

        $firArr = array();

        foreach ($catModels as $catModelKey => $catModel) {
            if ($catModel->parent_id == 0) {
                $firArr[$catModelKey] = array();
                $firArr[$catModelKey]['firModel'] = $catModel;
                $firArr[$catModelKey]['child'] = array();
                foreach ($catModels as $subModelKey => $subModel) {
                    if ($subModel->parent_id == $catModel->id) {
                        $firArr[$catModelKey]['child'][$subModelKey] = $subModel;
                    }
                }
            }
        }
        print_r(json_encode($firArr));
        die();
        return $this->render('list');
    }
    
    public function actionDetail()
    {
        return $this->render('detail');
    }

}
