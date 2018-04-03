<?php

namespace api\controllers;

use Yii;
use api\models\Smsdata;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SmsdataController implements the CRUD actions for Smsdata model.
 */
class SmsdataController extends Controller
{
    /**
     * Deletes an existing Smsdata model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function delete($phone)
    {
        $smsdata = Smsdata::find()
        ->where(['phone' => $phone])
        ->one();
        $smsdata->delete();
    }

}
