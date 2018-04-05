<?php

namespace api\controllers;
use Yii;
use common\models\User;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use yii\web\UploadedFile;

class PersonalController extends ActiveController
{
    public $modelClass = 'common\models\User';

    /* 过滤器实现认证 */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticatior' => [
                'class' => QueryParamAuth::className()
            ]
        ]);
    }
    /* 获取个人用户信息 */
    public function actionUserProfile()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $result = array();
        $result['phone'] = $user->phone;
        $result['username'] = $user->username;
        $result['gender'] = $user->gender;
        $result['picture'] = $user->picture;
        return $result;
    }
    public function actionUpdateUsername()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $post_data = Yii::$app->request->post();
        $username = $post_data['username'];
        $user->username = $username;
        $user->save();
        return ['status' => '200'];
    }
    public function actionUpdateGender()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $post_data = Yii::$app->request->post();
        $gender = $post_data['gender'];
        $user->gender = $gender;
        $user->save();
        return ['status' => '200'];
    }
    public function actionUpdateHeadimg()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $post_data = Yii::$app->request->post();
        $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $file = UploadedFile::getInstanceByName('headimg');
        if ($file) {
            $ext = $file->getExtension();
            $randName = time() . rand(1000, 9999) . '.' . $ext;
            $img_rootPath .= 'head_img/';
            if (!file_exists($img_rootPath)) {
                mkdir($img_rootPath, 0777, true);
            }
            $file->saveAs($img_rootPath . $randName);
            $user->picture = '/'.Yii::$app->params['upload_img_dir'] . 'head_img/' . $randName;
            $user->save();
            return ['status' => '200'];
        }
        return ['status' => '-1', 'msg' => '图片为空'];
    }
}
