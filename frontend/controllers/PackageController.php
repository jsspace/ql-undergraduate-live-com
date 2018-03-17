<?php

namespace frontend\controllers;

use yii\web\Controller;
use backend\models\CoursePackageCategory;
use backend\models\CoursePackage;
use Yii;
use backend\models\Course;


class PackageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//             'cache' => [
//                 'class' => 'yii\filters\PageCache',
//                 'duration' => 60,
//                 'variations' => [
//                     \Yii::$app->language,
//                 ],
//             ],
            'checker' => [
                'class' => 'backend\libs\CheckerFilter',
            ],
        ];
    }
    
    
    public function actionList()
    {
        $catModels = CoursePackageCategory::find()
        ->all();
        
        $packagemodels = CoursePackage::find()
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
                        $firArr[$catModelKey]['child'][$subModelKey]['package'] = array();
                        foreach ($packagemodels as $packageKey => $packagemodel) {
                            if(strstr($packagemodel->category_name, $subModel->name) != false)
                            {
                                $firArr[$catModelKey]['child'][$subModelKey]['package'][$packageKey] = $packagemodel;
                            }
                        }
                    }
                }
            }
        }
        return $this->render('list', ['packageLists' => $firArr]);
    }
    
    public function actionDetail()
    {
        $packageid = Yii::$app->request->get('pid');
        $packageModel = CoursePackage::find()
        ->where(['id' => $packageid])
        ->one();
        $packageDetail = array();
        $packageDetail['package'] = $packageModel;
        $packageDetail['course'] = array();
        $courses = Course::find()
        ->all();
        $courseids = explode(',', $packageModel->course);
        foreach ($courseids as $courseid) {
            foreach ($courses as $courseKey => $course) {
                if ($course->id == $courseid) {
                    $packageDetail['course'][$courseKey] = $course;
                    break;
                }
            }
        }
        return $this->render('detail', ['packageDetail' => $packageDetail]);
    }

}
