<?php
namespace api\controllers;

use yii;
use yii\web\Controller;
use backend\models\Message;

class MessageController extends Controller {
  //消息中心列表
  public function actionList(){
    $messages = Message::find()
        ->orderBy('publish_time desc')
        ->all();
        //取数据
    $message_arr = array();
        foreach ($messages as $key => $message) {
            $message_arr[] = array(
                'title' => $message->title,
                'publish_time' => $message->publish_time,
            );
        }
        return json_encode($message_arr);
        }
}