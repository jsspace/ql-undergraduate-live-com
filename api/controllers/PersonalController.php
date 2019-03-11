<?php

namespace api\controllers;
use backend\models\CourseChapter;
use backend\models\GoldLog;
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
use yii\db\Query;

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
        $post_data = Yii::$app->request->post();
        $alipay = $post_data['alipay_account'];
        $user->alipay_account = $alipay;
        $user->save();
        return ['status' => '200'];
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
        $result['couse_list'] = $courseList;
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
    /* 个人中心-我的课程-视频页接口 */
    public function actionCourseVideo()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $course_id = $data['course_id'];
        // 判断用户是否购买该课程
        $isPay = Course::ispay($course_id, $user->id);
        $course = Course::find()
            ->where(['id' => $course_id])
            ->with([
                'courseChapters' => function($query) use($user){
                    $query->with(['courseSections' => function($query) use($user){
                        $query->with(['courseSectionPoints' => function($query) use($user) {
                            $query->with(['studyLog' => function($query) use($user) {
                                $query->where(['userid' => $user->id]);
                            }]);
                        }] );
                    }]);
                },
                'teacher'
            ])->asArray()
            ->one();
        $result = array();
        $result['course'] = $course;
        return $result;
    }

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
                                    $query->where(['user_id' => $user->id]);
                                }]);
                            }] );
                        }
                    ])->one();
        $homeworks = 0;
        $submit_num = 0;
        $course_chapters = $course_homework->courseChapters;
        foreach ($course_chapters as $key => $chapter) {
            $sections = $chapter->courseSections;
            $homeworks += count($sections);
            foreach ($sections as $key => $section) {
                $user_homeworks = $section->userHomework;
                foreach ($user_homeworks as $key => $user_homework) {
                    if ($user_homework->status == 2) {
                        $submit_num += 1;
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
        $user = User::findIdentityByAccessToken($access_token);

        $file_info = Yii::$app->request->post();
        $count = $file_info['count'];
        $section_id = $file_info['section_id'];
        $course_id = $file_info['course_id'];

        $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $model = new UserHomework();
        $model->user_id = $user->id;
        $model->course_id = $course_id;
        $model->section_id = $section_id;

        $img_rootPath .= 'user_homework/';
        if (!file_exists($img_rootPath)) {
            mkdir($img_rootPath, 0777, true);
        }
        for ($i = 0; $i < $count; $i++){
            $file = $_FILES['file' . $i];
            if ($file['error'] != 1) {
                $ext = array_pop(explode('.', $file['name']));
                $randName = time() . rand(1000, 9999) . '.' . $ext;

                move_uploaded_file($file['tmp_name'], $img_rootPath . $randName);
                $folder = 'user_homework';
                $result = QiniuUpload::uploadToQiniu($file, $img_rootPath . $randName, $folder, $ext);
                if (!empty($result)) {
                    print_r(Yii::$app->params['get_source_host'].'/'.$result[0]['key']);
                    $model->pic_url = $model->pic_url . ';' .Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                    @unlink($img_rootPath . $randName);
                }else {
                    return json_encode([
                        'status' => 'failed',
                        'reason' => 'uploadfailed'
                    ]);
                }
            }
        }
        $model->status = 1;
        $model->submit_time =  date('Y-m-d H:i:s',time());
        if ($model->save()) {
            return json_encode([
                'status' => 'success',
                'reason' => '上传成功！'
            ]);
        }else {
            return json_encode([
                'status' => 'failed',
                'reason' => 'save failed！'
            ]);
        }
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
            ->where(['userid' => $user->id])->all();
        $gold_balance = GoldLog::find()->select('gold_balance')
            ->where(['userid' => $user->id, 'operation_time' =>
                GoldLog::find()->where(['userid' => $user->id])->max('operation_time')
            ])->one();
        $result = array();
        $result['gold_info'] = $gold_info;
        $result['gold_balance'] = $gold_balance->gold_balance;
        return $result;
    }

    public function actionOrderedList()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $order_info = (new Query())->select('tbl_order_goods.goods_name,')
                    ->from('tbl_order_goods')->where(['user_id' => $user->id])->all();
        return $order_info;
    }

}
