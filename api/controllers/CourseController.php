<?php

namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use backend\models\Course;
use backend\models\CourseCategory;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class CourseController extends Controller
{
    /**
     * @inheritdoc
     */

    public function actionList()
    {
        $cat = Yii::$app->request->get('cat');
        $catModel = CourseCategory::find()
        ->where(['id' => $cat])
        ->one();
        print_r($catModel);
        die();
        $coursemodels = Course::find()
        ->where(['onuse' => 1])
        ->all();
        $classes = CoursePackage::find()
        ->where(['onuse' => 1])
        ->all();
        $collegeArr = array();
        $collegeArr['college'] = $catModel;
        foreach ($coursemodels as $key => $coursemodel) {
            $categoryids = explode(',', $coursemodel->category_name);
            if (in_array($catModel->id, $categoryids)) {
                $collegeArr['college_course'][$key] = $coursemodel;
                $collegeArr['college_teacher'][$key] = $coursemodel->teacher_id;
            }
        }
        foreach ($classes as $key => $classmodel) {
            $categoryids = explode(',', $classmodel->category_name);
            if (in_array($catModel->id, $categoryids)) {
                $collegeArr['college_class'][$key] = $classmodel;
            }
        }
        return $collegeArr;
    }
    public function actionDetail()
    {

    }
}
