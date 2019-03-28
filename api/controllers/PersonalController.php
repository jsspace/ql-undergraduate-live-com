<?php

namespace api\controllers;
use backend\models\CourseChapter;
use backend\models\CoursePackage;
use backend\models\GoldLog;
use backend\models\UserHomework;
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
use backend\models\UserStudyLog;
use components\helpers\QiniuUpload;
use yii\base\Exception;
use common\service\PersonalService;

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
        // $school = ShandongSchool::find()
        // ->where(['id' => $user->schoolid])
        // ->one();
        $study_time = UserStudyLog::find()->where(['userid' => $user->id])->sum('duration');
        $result = array();
        $result['phone'] = $user->phone;
        $result['username'] = $user->username;
        $result['gender'] = $user->gender;
        $result['picture'] = $user->picture;
        //$result['school'] = $school->school_name;
        $result['study_time'] = $study_time;
        $result['address'] = $user->address;
        $result['alipay_account'] = $user->alipay_account;
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
    /**
     * 修改头像
     */
    public function actionUpdateHeadimg()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
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
            $folder = 'head_img';
            $result = QiniuUpload::uploadToQiniu($file, $img_rootPath . $randName, $folder);
            if (!empty($result)) {
                $user->picture = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
            }
            @unlink($img_rootPath . $randName);
            $user->save();
            return ['status' => 0, 'url' => $user->picture];
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
        $alipay = $data['alipay_account'];
        $user->alipay_account = $alipay;
        $user->save();
        return ['status' => '200'];
    }

    /**
     * 显示支付宝账号
     */
    public function actionGetAlipay() {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        return ($user->alipay_account);
    }

    /**
     * 修改收货地址，支付宝，用户名
     */
    public function actionChangeSet() {
      $get = Yii::$app->request->get();
      $access_token = $get['access-token'];
      $data = Yii::$app->request->post();
      $user = User::findIdentityByAccessToken($access_token);
      $user->alipay_account = $data['alipay_account'];
      $user->username = $data['username'];
      $user->address = $data['address'];
      $user->save();
      return ['status' => 0];
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
        $study_time = UserStudyLog::find()->where(['userid' => $user->id])->sum('duration');
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
        $courseList = array();
        foreach ($clist as $key => $course) {
            $teachers = explode(',', $course->teacher_id);
            $teachers = User::find()->select('username')->where(['in', 'id', $teachers])->all();
            $teacher = array();
            for ($i = 0; $i < count($teachers); $i++) {
                $teacher[] = $teachers[$i]->username;
            }
            $chapters = CourseChapter::find()->where(['course_id' => $course->id])->count();
            $content = array(
                'course_id' => $course->id,
                'course_name' => $course->course_name,
//                'discount' => $course->discount,
                'invalid_time' => date('Y-m-d',$course_invalid_time[$course->id]),
                'list_pic' => $course->list_pic,
                'chapters' => $chapters,     // 课程单元数
                'teachers' => $teacher      // 授课教师
            );
            $courseList[] = $content;
        }
        $result['course_list'] = $courseList;
        $result['course_count'] = count($clist);    // 课程数量
        $result['study_time'] = $study_time;        // 学习时长
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
            ->with('goods')->orderBy('add_time DESC')->all();
        $result = array();
        $info = array();
        foreach ($all_orders as $key => $order) {
            $course_ids = $order->course_ids;
            //$course_ids = substr($course_ids,0,strlen($course_ids)-1);
            $course_id_arr = explode(',', $course_ids);
            $courses = array();
            if ($order->goods->type == 'course') {
                $goods_pic = Course::find()->select(['home_pic', 'list_pic'])
                    ->where(['id' => $order->goods->goods_id])->one();
            } elseif ($order->goods->type == 'course_package') {
                $goods_pic = CoursePackage::find()->select(['home_pic', 'list_pic'])
                    ->where(['id' => $order->goods->goods_id])->one();
            }
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
            $info[] = array(
                'goods_name'=> $order->goods->goods_name,
                'market_price' => $order->goods->market_price,
                'goods_pic' => $goods_pic,
                'type' => $order->goods->type,
                'courses' => $courses,
                'add_time' => date('Y-m-d H:i:s',$order->add_time),
                'goods_amount' => $order->goods_amount,
                'order_sn' => $order->order_sn,
                'pay_status' => $order->pay_status
            );
        }
        $result['order_info'] = $info;
        return $result;
    }
    /**
     * 个人消息列表
     */
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
        $date = $data['date'];
        $time = strtotime($date .'00:00:00');
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
        ->andWhere(['>','pay_time' , $time])
        ->all();

        foreach ($orders as $key => $order) {
            $userpic = User::find()
            ->where(['id' => $order->user_id])
            ->one();
            $content = array(
                'pic' => $userpic->picture,
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
                'pic' => $usersingle->picture,
                'consignee' => $usersingle->username,
                'status' => '注册',
                'income' =>  0,
                'pay_time' => date('Y-m-d H:i:s', $usersingle->created_at)
            );
            $result[] = $content;
        }
             array_multisort(array_column($result,'pay_time'),SORT_DESC,$result);
        return  ($result);
    }

     /**
     * 个人收益按日期查询
     */
    public function actionIncomeCheck() {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $date = $data['date'];
        $time = strtotime($date);
        $user = User::findIdentityByAccessToken($access_token);
        $result = array();
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
        ->andWhere(['>','pay_time' , $time-1])
        ->andWhere(['<','pay_time' , $time+86400])
        ->all();
            foreach ($orders as $key => $order) {
                $userpic = User::find()
                ->where(['id' => $order->user_id])
                ->one();
                $content = array(
                    'pic' => $userpic->picture,
                    'consignee' => $order->consignee,
                    'status' => '下单',
                    'income' => $order->order_amount * 0.1,
                    'pay_time' => date('Y-m-d H:i:s', $order->pay_time)
                );
                $result[] = $content;
            }
        $users = User::find()
        ->where(['invite' => $user->id])
        ->andWhere(['>','created_at', $time-1])
        ->andWhere(['<','created_at', $time+86400])
        ->all();
        $user_array=array();
        foreach ($users as $key => $usersingle) {
            $user_array[] = $usersingle->id;
            $content = array(
                'pic' => $usersingle->picture,
                'consignee' => $usersingle->username,
                'status' => '注册',
                'income' =>  0,
                'pay_time' => date('Y-m-d H:i:s', $usersingle->created_at)
            );
            $result[] = $content;
        }
             array_multisort(array_column($result,'pay_time'),SORT_DESC,$result);
        return  ($result);
    }

    /**
     * 个人收益
     */
    public function actionIncome() {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        // 查询邀请人是当前用户的所有用户信息
        $users = User::find()
        ->where(['invite' => $user->id])
        ->all();
        // 将这些用户的id信息放到user_array数组中
        $user_array=array();
        foreach ($users as $key => $usersingle) {
            $user_array[] = $usersingle->id;
        }
        // 查询这些用户的所有已支付且已完成的订单信息
        $orders = OrderInfo::find()
        ->where(['in', 'user_id', $user_array])
        ->andWhere(['order_status' => 1])
        ->andWhere(['pay_status' => 2])
        ->all();
        // 总佣金income等于所有订单总额的百分之一
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
        return ($result);
    }

    /**
     * 获取按月收益
     */
    public function actionIncomeMonth () {
        $this_month = strtotime(date('Y-m-01', strtotime(date("Y-m-d"))));
        $now = strtotime(date('Y-m-d'));
        $last_month = strtotime(date('Y-m-01', (strtotime(date('Y-m')) - 1)));
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $per = new PersonalService();
        $this_month_income = $per->countIncome($this_month,$now,$user->id);
        $last_month_income = $per->countIncome($last_month,$this_month-1,$user->id);
       
        $month1 = array(
            'month' => date('Y-m',$this_month),
            'income' => $this_month_income,
            'myincome' => round($this_month_income*0.1,2),
        );
        $result[] = $month1;
        $month2 = array(
            'month' => date('Y-m',$last_month),
            'income' => $last_month_income,
            'myincome' => round($last_month_income*0.1,2),
        );
        $result[] = $month2;
        return ($result);
    }

    /**
     * 根据传入的月份返回收益
     */
    public function actionIncomeMonthCheck () {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $date = strtotime($data['date']);
        $date2 = strtotime($data['date2']);
        $per = new PersonalService();
        $user = User::findIdentityByAccessToken($access_token);
        $income = $per->countIncome($date,$date2,$user->id);
        $result1 = array(
            'month' => date('Y-m',$date).'-'.date('Y-m',$date2),
            'income' => $income,
            'myincome' => round($income*0.1,2),
        );
        $result[] = $result1;
        $month2 = array(
            'month' => '',
            'income' => '',
            'myincome' => '',
        );
        $result[] = $month2;
        return ($result);
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
                'discount' => $f->discount,
                'id' => $f->id
            );
        }
        return ($favorite_arr);
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
//    /* 个人中心-我的课程-视频页接口 */
//    public function actionCourseVideo()
//    {
//        $data = Yii::$app->request->get();
//        $access_token = $data['access-token'];
//        $course_id = $data['course_id'];
//        $user = User::findIdentityByAccessToken($access_token);
//        // 判断用户是否购买该课程
//        $isPay = Course::ispay($course_id, $user->id);
//        $course = Course::find()
//            ->where(['id' => $course_id])
//            ->with([
//                'courseChapters' => function($query) use($user){
//                    $query->with(['courseSections' => function($query) use($user){
//                        $query->with(['courseSectionPoints' => function($query) use($user) {
//                            $query->with(['studyLog' => function($query) use($user) {
//                                $query->where(['userid' => $user->id]);
//                            }]);
//                        }] );
//                    }]);
//                },
//                'teacher'
//            ])->asArray()
//            ->one();
//        $result = array();
//        $result['course'] = $course;
//        return $result;
//    }

    /* 个人中心-我的课程-课程作业接口 */
    public function actionCourseHomework()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $course_id = $data['course_id'];
        $course_homework = Course::find()
                    ->where(['id' => $course_id])
                    ->with([
                        'courseChapters' => function($query) use($user) {
                            $query->with(['courseSections' => function($query) use($user) {
                                $query->with(['userHomework' => function($query) use($user) {
                                    $query->where(['user_id' => $user->id])->orderBy('submit_time DESC');
                                }]);
                            }] );
                        }
                    ])->asArray()->one();
        $homeworks = 0;
        $submit_num = 0;
        $course_chapters = $course_homework['courseChapters'];
        foreach ($course_chapters as $key1 => $chapter) {
            $sections = $chapter['courseSections'];
            $homeworks += count($sections);
            foreach ($sections as $key2 => $section) {
                $user_homeworks = $section['userHomework'];
                $max = 0;
                foreach ($user_homeworks as $key3 => $user_homework) {
                    if ($user_homework['status']  == 2) {
                        $submit_num += 1;
                    }
                    if ($user_homework['submit_time'] > $max) {
                        $course_chapters[$key1]['courseSections'][$key2]['userHomewoek'] = array();
                    }
                }
            }
        }
        $result = array();
        $result['course'] = $course_homework;   // 包含了课程基本信息、章节信息、作业信息等
        $result['homeworks'] = $homeworks;      // 应交次数
        $result['submit_num'] = $submit_num;    // 实交次数
        return $result;
    }

    /* 个人中心-我的课程-课程作业上传 */
    public function actionHomeworkUpload()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $section_id = $data['section_id'];
        $course_id = $data['course_id'];
        $user = User::findIdentityByAccessToken($access_token);
        $file = UploadedFile::getInstanceByName('homeworkImg');
        $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];

        $model = UserHomework::find()->where(['course_id' => $course_id, 'section_id' => $section_id, 'user_id' => $user->id, 'status' => 1])->one();
        if (empty($model)) {
            $model = new UserHomework();
            $model->user_id = $user->id;
            $model->course_id = $course_id;
            $model->section_id = $section_id;
        }
        if ($file) {
            $ext = $file->getExtension();
            $randName = time() . rand(1000, 9999) . '.' . $ext;
            $img_rootPath .= 'user_homework/';
            if (!file_exists($img_rootPath)) {
                mkdir($img_rootPath, 0777, true);
            }
            $file->saveAs($img_rootPath . $randName);
            $folder = 'user_homework';
            $result = QiniuUpload::uploadToQiniu($file, $img_rootPath . $randName, $folder);
            if (!empty($result)) {
                $model->pic_url = $model->pic_url . Yii::$app->params['get_source_host'].'/'.$result[0]['key'] . ';';
                $model->status = 1;
                $model->submit_time =  date('Y-m-d H:i:s',time());
            }
            @unlink($img_rootPath . $randName);
            $model->save();
            sleep(1);
            return ['status' => 0, 'msg' => $model->pic_url];
        }
        return ['status' => -1, 'msg' => '图片为空'];

    }


    /* 个人中心-我的课程-单元测试 */
    public function actionTestList()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $course_id = $data['course_id'];
        // 获取学情
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://exam.kaoben.top/?r=apitest/getexambyuser&userid=$user->id&courseid=$course_id");
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $xueqing = curl_exec($curl);
        curl_close($curl);
        $xueqing = json_decode($xueqing);
        return $xueqing;
    }

    /* 个人中心-我的金币 */
    public function actionGoldInfo()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $gold_info = GoldLog::find()
            ->where(['userid' => $user->id])->orderBy('operation_time DESC')->all();
        $gold_balance = GoldLog::find()->select('gold_balance')
            ->where(['userid' => $user->id, 'operation_time' =>
                GoldLog::find()->where(['userid' => $user->id])->max('operation_time')
            ])->one();
        $result = array();
        $result['gold_info'] = $gold_info;
        $result['gold_balance'] = $gold_balance->gold_balance;
        return $result;
    }

//    public function actionOrderedList()
//    {
//        $data = Yii::$app->request->get();
//        $access_token = $data['access-token'];
//        $user = User::findIdentityByAccessToken($access_token);
//        $order_info = (new Query())->select('tbl_order_goods.goods_name,')
//                    ->from('tbl_order_goods')->where(['user_id' => $user->id])->all();
//        return $order_info;
//    }

    /* 课程收藏api */
    public function actionCollectionCourse()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $course_id = $data['course_id'];
        $status = 0;
        $result = array();
        try {
            $user = User::findIdentityByAccessToken($access_token);
            $coll = Collection::find()->where(['userid' => $user->id, 'courseid' => $course_id])->one();
            if (empty($user)) {
                $status = -1;
                $result['message'] = 'user was not found!';
                $result['status'] = $status;
                return $result;
            } elseif (empty($coll)) {
                $collection = new Collection();
                $collection->userid = $user->id;
                $collection->courseid = $course_id;
                $collection->save();
                $status = 0;
            } else {
                $coll -> delete();
                $status = 0;
            }

        } catch (Exception $e) {
            $status = -1;
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        } finally {
            $result['status'] = $status;
            return $result;
        }
    }
    /**
     * 获取学习时长
     */
    public function actionDuration(){
      $data = Yii::$app->request->get();
      $access_token = $data['access-token'];
      $user = User::findIdentityByAccessToken($access_token);
      $study_log = UserStudyLog::find()
        ->where(['userid' => $user->id])
        ->select('duration')
        ->all();
      $alltime = 0;
      foreach ($study_log as $key => $time) {
        $alltime += $time->duration;
      }
      $hour = 0;
      $minute = $alltime % 60;
      while(($alltime / 60) > 1){
        $alltime = $alltime - 60;
        $hour ++;
      }
      $duration = array();
      $duration['hour']  = $hour;
      $duration['minute'] = $minute;
      return $duration;
    }

}
