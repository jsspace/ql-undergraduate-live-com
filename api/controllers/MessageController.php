<?php
namespace api\controllers;

use yii;
use yii\web\Controller;
use backend\models\Message;

class MessageController extends Controller {
  //市场专员消息中心列表
  public function actionList(){
        $get = Yii::$app->request->get();
        $access_token = $get['access-token'];
        $user = \common\models\User::findIdentityByAccessToken($access_token);
        $msgs = Message::find()
            ->where(['publisher' => $user->id])
            ->orderBy('publish_time desc')
            ->all();
        $msg_arr = array();
        foreach ($msgs as $key => $msg) {
            $msg_arr[] = array(
                'title' => $msg->title,
                'publish_time' => $msg->publish_time,
            );
        }
        return json_encode($msg_arr);
  }
}