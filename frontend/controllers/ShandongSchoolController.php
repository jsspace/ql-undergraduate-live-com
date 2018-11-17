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

    public function actionGetSchools()
    {
        $request = Yii::$app->request->post();
        $keywords = $request['keywords'];
        $cityid = $request['cityid'];
        $schools= ShandongSchool::find()
        ->where(['cityid' => $cityid])
        ->andWhere(['like', 'school_name', $keywords])
        //->createCommand()
        //->getRawSql();
        ->all();
        $spanList = '';
        $schoolList = '';
        foreach ($schools as $school) {
            $spanList.='<span class="tag" data-value='.$school->id.'>'.$school->school_name.'</span>';
            $schoolList.=$school->school_name;
        }
        $result = array(
            'spanList' => $spanList,
            'schoolList' => $schoolList
        );
        return json_encode($result);
    }
}
