<?php

namespace api\controllers;
use Yii;
use common\models\User;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use yii\web\UploadedFile;
use backend\models\Course;
use backend\models\OrderInfo;
use yii\helpers\Url;

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
        $result['picture'] = Url::to('@web'.$user->picture, true);
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
            return ['status' => '200', 'url' => Url::to('@web'.$user->picture, true)];
        }
        return ['status' => '-1', 'msg' => '图片为空'];
    }
    public function actionCourseList()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $orderids = OrderInfo::find()
        ->select('course_ids, invalid_time')
        ->where(['user_id' => $user->id])
        ->andWhere(['pay_status' => 2])
        ->asArray()
        ->all();
        $goodsids = '';
        $course_invalid_time = [];
        foreach ($orderids as $key => $orderid) {
            $goodsids.=$orderid['course_ids'].',';
            $courseid_arr = explode(',', $orderid['course_ids']);
            foreach ($courseid_arr as $key => $courseid) {
                $course_invalid_time[$courseid] = $orderid['invalid_time'];
            }
        }
        $goodsid_arr = explode(',', $goodsids);
        $clist = Course::find()
        ->where(['in', 'id', $goodsid_arr])
        ->all();
        $result = array();
        foreach ($clist as $key => $course) {
            $content = array(
                'course_id' => $course->id,
                'course_name' => $course->course_name,
                'discount' => $course->discount,
                'invalid_time' => date('Y-m-d',$course_invalid_time[$course->id]),
                'list_pic' => Url::to('@web'.$course->list_pic, true)
            );
            $result[] = $content;
        }
        return $result;
    }
    public function actionOrderList()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        //所有订单
        $all_orders = OrderInfo::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->orderBy('add_time desc')
        ->all();
        $result = array();
        foreach ($all_orders as $key => $order) {
            $course_ids = $order->course_ids;
            $course_ids = substr($course_ids,0,strlen($course_ids)-1);
            $course_id_arr = explode(',', $course_ids);
            $courses = array();
            foreach ($course_id_arr as $key => $course_id) {
                $course = Course::find()
                ->where(['id' => $course_id])
                ->one();
                $content = array(
                    'course_id' => $course->id,
                    'course_name' => $course->course_name,
                    'list_pic' => Url::to('@web'.$course->list_pic, true)
                );
                $courses[] = $content;
            }
            $result[] = array(
                'courses' => $courses,
                'add_time' => date('Y-m-d H:i:s',$order->add_time),
                'goods_amount' => $order->goods_amount,
                'pay_status' => $order->pay_status
            );
        }
        return $result;
    }
}
