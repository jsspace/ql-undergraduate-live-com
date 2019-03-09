<?php
namespace api\controllers;

use yii;
use yii\web\Controller;
use backend\models\Information;

class InformationController extends Controller 
{
  //资讯列表
  public function actionList()
  {
    $informations = Information::find()
        ->orderBy('release_time desc')
        ->all();
        $information_arr = array();
        foreach ($informations as $key => $information) {
            $information_arr[] = array(
                'title' => $information->title,
                'author' => $information->author,
                'release_time' => $information->release_time,
                'pic' =>  $information->cover_pic,
                'id' => $information->id
            );
        }
      return json_encode($information_arr);
  }
  //资讯信息
  public function actionInfo(){
    $data = Yii::$app->request->get();
    $id = $data['id'];
    $information = Information::find()
    ->where(['id' => $id])
    ->one();
    $info_show = array();
    $info_show = array(
      'title' => $information->title,
      'content' => $information->content,
      'release_time' => $information->release_time,
      'author' => $information->author
    );
    return json_encode($info_show);
  }
}