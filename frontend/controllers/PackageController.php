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
        ];
    }
    
    
    public function actionList()
    { 
        $packagemodels = CoursePackage::find()
        ->where(['onuse' => 1])
        ->all();
        return $this->render('list', ['packageLists' => $packagemodels]);
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
