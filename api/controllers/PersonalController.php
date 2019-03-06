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
use backend\models\Read;
use backend\models\Message;
use backend\models\ShandongSchool;
use backend\models\Withdraw;
use backend\models\Collection;

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
        $school = ShandongSchool::find()
        ->where(['id' => $user->schoolid])
        ->one();
        $result = array();
        $result['phone'] = $user->phone;
        $result['username'] = $user->username;
        $result['gender'] = $user->gender;
        $result['picture'] = Url::to('@web'.$user->picture, true);
        $result['school'] = $school->school_name;
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

    /**
     * 修改支付宝账号
     */
    public function actionUpdateAlipay() {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $post_data = Yii::$app->request->post();
        $alipay = $post_data['alipay_account'];
        $user->alipay_account = $alipay;
        $user->save();
        return ['status' => '200'];
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
                'list_pic' => $course->list_pic
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
        ->where(['user_id' => $user->id])
        ->orderBy('add_time desc')
        ->all();
        $result = array();
        foreach ($all_orders as $key => $order) {
            $course_ids = $order->course_ids;
            //$course_ids = substr($course_ids,0,strlen($course_ids)-1);
            $course_id_arr = explode(',', $course_ids);
            $courses = array();
            foreach ($course_id_arr as $key => $course_id) {
                $course = Course::findOne($course_id);
                if (!empty($course)) {
                    $content = array(
                        'course_id' => $course->id,
                        'course_name' => $course->course_name,
                        'discount' => $course->discount,
                        'list_pic' => $course->list_pic
                    );
                    $courses[] = $content;
                }
            }
            $result[] = array(
                'courses' => $courses,
                'add_time' => date('Y-m-d H:i:s',$order->add_time),
                'goods_amount' => $order->goods_amount,
                'order_sn' => $order->order_sn,
                'pay_status' => $order->pay_status
            );
        }
        return $result;
    }
    public function actionMessageList()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $messages = Read::find()
        ->where(['userid' => $user->id])
        ->orderBy([
          'status' => SORT_ASC,
          'get_time'=>SORT_DESC
        ])->all();
        $result = array();
        $models = Message::find()
        ->all();
        $title = array();
        foreach ($models as $key => $model) {
            $title[$model->msg_id]['title'] = $model->title;
            $title[$model->msg_id]['content'] = $model->content;
        }
        foreach ($messages as $key => $message) {
            $content = array(
                'id' => $message->id,
                'status' => $message->status,
                'get_time' => date('Y-m-d H:i:s',$message->get_time),
                'title' => $title[$message->msg_id]['title'],
                'content' => $title[$message->msg_id]['content'],
            );
            $result[] = $content;
        }
        return $result;
    }
    public function actionMessageView()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $postdata = Yii::$app->request->post();
        $read_id = $postdata['read_id'];
        $readModel = Read::findOne($read_id);
        $readModel->status = 1;
        $readModel->read_time = time();
        $readModel->save(false);
        $message = Message::findOne($readModel->msg_id);
        $publisher = User::findOne($message->publisher);
        $result = array(
            'get_time' => date('Y-m-d H:i:s',$readModel->get_time),
            'title' => $message->title,
            'content' => $message->content,
            'publisher' => $publisher->username
        );
        return $result;
    }

    /**
     * 个人收益明细
     */
    public function actionIncomeStatistics() {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $year = $data['year'];
        $mounth = $data['mounth'];
        $time = strtotime($year.$mounth.'00'.' '.'00:00:00');
        $user = User::findIdentityByAccessToken($access_token);
        $users = User::find()
        ->where(['invite' => $user->id])
        ->all();
        $user_array=array();
        foreach ($users as $key => $usersingle) {
            $user_array[] = $usersingle->id;
        }
      
        $orders = OrderInfo::find()
        ->where(['in', 'user_id', $user_array])
        ->andWhere(['order_status' => 1])
        ->andWhere(['pay_status' => 2])
        ->andWhere(['>','pay_time', $time])
        ->all();

        foreach ($orders as $key => $order) {
            $content = array(
                'consignee' => $order->consignee,
                'status' => '下单',
                'income' => $order->order_amount * 0.1,
                'pay_time' => date('Y-m-d H:i:s', $order->pay_time)
            );
            $result[] = $content;
        }

        $users = User::find()
        ->where(['invite' => $user->id])
        ->andWhere(['>','created_at', $time])
        ->all();
        $user_array=array();
        foreach ($users as $key => $usersingle) {
            $user_array[] = $usersingle->id;
            $content = array(
                'consignee' => $usersingle->username,
                'status' => '注册',
                'income' =>  0,
                'pay_time' => date('Y-m-d H:i:s', $usersingle->created_at)
            );
            $result[] = $content;
        }

        array_multisort(array_column($result,'pay_time'),SORT_DESC,$result);
        return json_encode($result);
    }

    /**
     * 个人收益
     */
    public function actionIncome() {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $users = User::find()
        ->where(['invite' => $user->id])
        ->all();
        $user_array=array();
        foreach ($users as $key => $usersingle) {
            $user_array[] = $usersingle->id;
        }
      
        $orders = OrderInfo::find()
        ->where(['in', 'user_id', $user_array])
        ->andWhere(['order_status' => 1])
        ->andWhere(['pay_status' => 2])
        ->all();
        
        $income=0;
        foreach ($orders as $key => $order) {
            $income += $order->order_amount * 0.1;
        }

        $settlement = Withdraw::find()
        ->where(['user_id' => $user->id])
        ->all();

        $widthincome = 0;
        foreach ($settlement as $key => $settlementsingle) {
            $widthincome += $settlementsingle->fee;
        }

        $result = array(
           'income' => $income,
           'settlement' => $widthincome
        );
        return json_encode($result);
    }

    //我的收藏
    public function actionCollectionList() {
      $data = Yii::$app->request->get();
      $access_token = $data['access-token'];
      $user = User::findIdentityByAccessToken($access_token);
      $collections = Collection::find()
        ->where(['userid' => $user->id])
        ->all();
        $courseid = '';
        foreach ($collections as $key => $collection) {
            $courseid.=$collection->courseid.',';
        }
        $courseid_arr = explode(',', $courseid);
        $flist = Course::find()
        ->where(['in', 'id', $courseid_arr])
        ->orderBy('create_time desc')
        ->all();
        $favorite_arr = array();
        foreach ($flist as $key => $f) {
            $favorite_arr[] = array(
                'course_name' => $f->course_name,
                'home_pic' => $f->home_pic,
                'price' => $f->price,
            );
        }
        return json_encode($favorite_arr);
    }
    //宣传页
    public function actionQrcode() {
      $data = Yii::$app->request->get();
      $access_token = $data['access-token'];
      $user = User::findIdentityByAccessToken($access_token);
      $invite_url = 'http://www.kaoben.top'.Url::to(['site/signup','invite' => $user->id]);
      $img_src = Url::to(['market/qrcode','url' => $invite_url, 'name' => $user->id.'.png']);
      return json_encode($img_src);
    }
    //宣传页 分享
    public function actionQrcodeShare() {
      $data = Yii::$app->request->get();
      $access_token = $data['access-token'];
      $user = User::findIdentityByAccessToken($access_token);
      $invite_url = 'http://www.kaoben.top'.Url::to(['site/signup','invite' => $user->id]);
      $img_src = Url::to(['market/qrcode','url' => $invite_url, 'name' => $user->id.'.png']);
      return json_encode($img_src);
    }
}
