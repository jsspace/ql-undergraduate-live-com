<?php

namespace api\controllers;

use Yii;
use backend\models\Audio;
use backend\models\AudioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AudioCategory;
use backend\models\AudioSection;
use yii\helpers\Url;

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
        $novalidactions = ['audio-home', 'get-audio'];
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
            $count = 0;
            foreach ($audio_models as $audiokey => $audio) {
                if ($count === 6) {
                    break;
                }
                if ($audio->category_id === $cat->id) {
                    $audioitem = array(
                        'id' => $audio->id,
                        'des' => $audio->des,
                        'pic' => Url::to('@web'.$audio->pic, true)
                    );
                    $audios[$catkey]['audioList'][] = $audioitem;
                    $count++;
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

    public function actionGetAudio()
    {
        $data = Yii::$app->request->get();
        $cat_id = $data['cat_id'];
        $cat_model = AudioCategory::find()
        ->where(['id' => $cat_id])
        ->one();
        if (!empty($cat_model)) {
            $audio_models = Audio::find()
            ->where(['category_id' => $cat_id])
            ->orderBy('id desc')
            ->all();
            $audios = array();
            $audios['cat'] = array(
                'id' => $cat_id,
                'catname' => $cat_model->name
            );
            $audios['audioList'] = array();
            foreach ($audio_models as $audiokey => $audio) {
                $audioitem = array(
                    'id' => $audio->id,
                    'des' => $audio->des,
                    'pic' => Url::to('@web'.$audio->pic, true)
                );
                $audios['audioList'][] = $audioitem;
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
    public function actionGetAudiosection($audio_id)
    {
        $data = Yii::$app->request->get();
        $audio_id = $data['audio_id'];
        $audio_model = Audio::find()
        ->where(['id' => $audio_id])
        ->one();
        $section_models = AudioSection::find()
        ->where(['audio_id' => $audio_id])
        ->orderBy('id desc')
        ->all();
        $audio_sections = array();
        $audio_sections['audio'] = array(
            'des' => $audio_model->des,
            'pic' => Url::to('@web'.$audio_model->pic, true)
        );
        $audio_sections['sectionList'] = array();
        foreach ($section_models as $sectionkey => $section) {
            $audioitem = array(
                'name' => $section->audio_name,
                'author' => $section->audio_author,
                'url' => $section->audio_url,
            );
            $audio_sections['sectionList'][] = $audioitem;
        }
        if (!empty($audio_sections)) {
            $response = array(
                'err_code' => '200',
                'data' => $audio_sections
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
}
