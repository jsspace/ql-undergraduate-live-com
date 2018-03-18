<?php

namespace frontend\controllers;

use Yii;
use backend\models\Audio;
use backend\models\AudioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AudioCategory;
use backend\models\AudioSection;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class AudioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        $currentaction = $action->id;
        $novalidactions = ['audio-home'];
        if(in_array($currentaction,$novalidactions)) {
            $action->controller->enableCsrfValidation = false;
        }
        parent::beforeAction($action);
        return true;
    }

    public function actionAudioHome()
    {
        $cat_models = AudioCategory::find()
        ->orderBy('position asc')
        ->all();
        $audio_models = Audio::find()
        ->orderBy('id desc')
        ->all();
        $audios = array();
        foreach ($cat_models as $catkey => $cat) {
            $catitem = array(
                'id' => $cat->id,
                'catname' => $cat->name
            );
            $audios[$catkey]['cat'] = $catitem;
            $audios[$catkey]['audioList'] = array();
            foreach ($audio_models as $audiokey => $audio) {
                if ($audio->id === $audio->category_id) {
                    $audioitem = array(
                        'id' => $audio->id,
                        'des' => $audio->des,
                        'pic' => $audio->pic
                    );
                    $audios[$catkey]['audioList'][] = $audioitem;
                }
            }
        }
        if (!empty($audios)) {
            $response = array(
                'err_code' => '200',
                'data' => $audios
            );
        } else {
            $response = array(
                'err_code' => '-1',
                'data' => '空数据'
            );
        }
        $response = json_encode($response);
        return $response;
    }

    public function actionGetAudio($audio_id)
    {
        
    }
}
