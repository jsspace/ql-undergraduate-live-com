<?php

namespace frontend\controllers;

use Yii;
use backend\models\ShandongSchool;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * ShandongSchoolController implements the CRUD actions for ShandongSchool model.
 */
class ShandongSchoolController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'schools' => ['POST'],
                ],
            ],
        ];
    }

    public function actionSchools()
    {
        $post = Yii::$app->request->post();
        $cityid = $post['cityid'];
        $model = ShandongSchool::schools($cityid);
        foreach($model as $id => $name) {
            echo Html::tag('option', Html::encode($name), array('value' => $id));
        }
    }
}
