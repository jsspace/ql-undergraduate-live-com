<?php

namespace frontend\controllers;

use yii;
use backend\models\Member;
use backend\models\CourseCategory;
use backend\models\MemberOrder;
use backend\models\CoursePackage;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use backend\models\MemberGoods;
use Da\QrCode\QrCode;
use yii\base\InvalidValueException;

/*require_once "../../common/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php";
require_once "../../common/alipay/pagepay/service/AlipayTradeService.php";

require_once "../../common/wxpay/lib/WxPay.Api.php";
require_once "../../common/wxpay/example/WxPay.NativePay.php";
require_once '../../common/wxpay/example/log.php';*/


class MemberController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['pay'],
                'rules' => [
                    [
                        'actions' => ['alipay', 'wxpay'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'pay' => ['post'],
                    'alinotify' => ['post'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        $currentaction = $action->id;
        $novalidactions = ['alinotify'];
        if(in_array($currentaction,$novalidactions)) {
            $action->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        $colleges = CourseCategory::find()
        ->all();
        $classes = CoursePackage::find()
        ->all();
        $members = array();
        foreach ($colleges as $key => $college) {
            $members[$key]['college'] = $college;
            $members[$key]['classes'] = array();
            foreach ($classes as $classeskey => $class) {
                if ($college->id === $class->category_name) {
                    $members[$key]['classes'][$classeskey] = $class;
                }
            }
        }
        print_r($members);
        die();
        return $this->render('index', ['members' => $members]);
    }
    public function actionIndexOld()
    {
        $member_items = [];
        $member_models = Member::find()
        ->orderBy('course_category_id asc,position asc')
        ->all();
        //已购买过的会员
        $member_orders_model = MemberGoods::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 2])
        ->andWhere(['>', 'end_time', time()])
        ->all();
        $buy_member_orders = [];
        foreach ($member_orders_model as $member_order_model) {
            $buy_member_orders[] = $member_order_model->member_id;
        }
        foreach ($member_models as $item) {
            $member_items[$item->course_category_id]['course_category'] = $item->content;
            $member_items[$item->course_category_id]['members'][] = $item;
        }
        $order_sn = CartController::createOrderid();
        return $this->render('index', ['member_items' => $member_items, 'buy_member_orders' => $buy_member_orders, 'order_sn' => $order_sn]);
    }
    
    public function actionAlipay()
    {
        $data = Yii::$app->request->post();
        if (empty($data['member_id'])) {
            throw new BadRequestHttpException('缺失参数。');
        }
        $member_ids = explode(',', $data['member_id']);
        //查看将要购买的会员类型
        $course_categorys = Member::find()
        ->where(['id' => $member_ids])
        ->groupBy('course_category_id')
        ->all();
        if (empty($course_categorys)) {
            throw new BadRequestHttpException('会员不存在。');
        }
        $course_category_ids_arr = [];
        foreach ($course_categorys as $course_category_id) {
            $course_category_ids_arr[] = $course_category_id->course_category_id;
        }
        //已购买过的会员
        $member_orders = MemberGoods::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 2])
        ->andWhere(['>', 'end_time', time()])
        ->all();
        $buy_course_category_ids_str = '';
        foreach ($member_orders as $member_order) {
            $buy_course_category_ids_str .= $member_order->course_category_id . ',';
        }
        $buy_course_category_ids_arr = explode(',', $buy_course_category_ids_str);
        if (array_intersect($buy_course_category_ids_arr, $course_category_ids_arr)) {
            //订单已存在
            throw new BadRequestHttpException('你购买相关会员了,请不要重复购买。');
        }
        $member_id_str = '';
        $course_category_id_str = '';
        $member_name = '';
        $order_amount = 0.00;
        foreach($course_categorys as $course_category) {
            $member_name .= $course_category->content . ' ';
            $order_amount += $course_category->discount;
        }
        //添加订单信息
        $order_info = new MemberOrder();
        $order_info->order_sn = $data['order_sn'];
        $order_info->user_id = Yii::$app->user->id;
        $order_info->order_status = 1;
        $order_info->pay_status = 0;
        $order_info->consignee = Yii::$app->user->identity->username;
        $order_info->mobile = Yii::$app->user->identity->phone;
        $order_info->email = Yii::$app->user->identity->email;
        //0 1支付宝 2 微信
        $order_info->pay_id = 1;
        $order_info->pay_name = '支付宝';
        $order_info->goods_amount = $order_amount;
        $order_info->order_amount = $order_amount;
        $order_info->add_time = time();
        $order_info->save(false);
        foreach($course_categorys as $course_category) {
            $member_goods_model = new MemberGoods();
            $member_goods_model->user_id = Yii::$app->user->id;
            $member_goods_model->order_sn = $data['order_sn'];
            $member_goods_model->member_id = $course_category->id;
            $member_goods_model->course_category_id = $course_category->course_category_id;
            $member_goods_model->member_name = $course_category->name;
            $member_goods_model->price = $course_category->price;
            $member_goods_model->discount = $course_category->discount;
            $member_goods_model->add_time = time();
            $member_goods_model->end_time = time() + $course_category->time_period * 3600 * 24;
            $member_goods_model->pay_status = 0;
            $member_goods_model->save();
        }
        $orderInfo = [
            'order_sn' => $data['order_sn'],
            'user_id' => Yii::$app->user->id,
            'consignee' => Yii::$app->user->identity->username,
            'email' => Yii::$app->user->identity->email,
            'phone' => Yii::$app->user->identity->phone,
            'order_name' => $member_name,
            'goods_amount' => $order_amount,
            'add_time' => time(),
        ];
        
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($data['order_sn']);
        
        //订单名称，必填
        $subject = trim($member_name);
        
        //付款金额，必填
        $total_amount = trim($order_amount);
        
        //商品描述，可空
        $body = json_encode($orderInfo);
        
        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        
        //获取配置信息
        $config = Yii::$app->params['alipay'];
        $aop = new \AlipayTradeService($config);
        
        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,Url::to(['user/orders'], true),Url::to(['member/alinotify'], true));
        
        //输出表单
        var_dump($response);
        
    
    }
    
    public function actionAlinotify()
    {
        $data = Yii::$app->request->Post();
        $arr=$data;
        //获取配置信息
        $config = Yii::$app->params['alipay'];
        $alipaySevice = new \AlipayTradeService($config);
        $alipaySevice->writeLog(var_export($data,true));
        $result = $alipaySevice->check($arr);
    
        /* 实际验证过程建议商户添加以下校验。
         1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
         2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
         3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
         4、验证app_id是否为该商户本身。
         */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代
    
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            //商户订单号
            $out_trade_no = $data['out_trade_no'];
            //支付宝交易号
            $trade_no = $data['trade_no'];
            //交易状态
            $trade_status = $data['trade_status'];
            //支付金额
            $total_amount = $data['total_amount'];

            if ($data['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                $order_info = MemberOrder::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['order_status' => 1])
                ->one();
                if (!empty($order_info) && $order_info->order_amount == $total_amount) {
                    if ($order_info->pay_status == 0) {
                        $order_info->pay_id = $trade_no;
                        $order_info->money_paid = $total_amount;
                        $order_info->pay_status = 2;
                        $order_info->pay_time = time();
                        $order_info->save(false);
                        MemberGoods::updateAll(['pay_status' => 2], ['order_sn' => $out_trade_no]);
                    }
                }
            } else if ($data['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                $order_info = MemberOrder::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['pay_status' => 0])
                ->andWhere(['order_status' => 1])
                ->one();
                
                if (!empty($order_info) && $order_info->order_amount == $total_amount) {
                    $order_info->pay_id = $trade_no;
                    $order_info->money_paid = $total_amount;
                    $order_info->pay_status = 2;
                    $order_info->pay_time = time();
                    $order_info->save(false);
                    MemberGoods::updateAll(['pay_status' => 2], ['order_sn' => $out_trade_no]);
                }
    
            } else if ($data['trade_status'] == 'TRADE_CLOSED') {
                //未付款交易超时关闭，或支付完成后全额退款
                $order_info = MemberOrder::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['order_status' => 1])
                ->one();
                if (!empty($order_info) && $order_info->order_amount == $total_amount) {
                    //未支付，取消订单
                    $order_info->pay_id = $trade_no;
                    $order_info->order_status = 2;
                    $order_info->pay_status = 0;
                    $order_info->invalid_time = time();
                    $order_info->save(false);
                }
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";	//请不要修改或删除
        }else {
            echo "fail";
        }
    
    }
    
    //模式二
    /**
     * 流程：
     * 1、调用统一下单，取得code_url，生成二维码
     * 2、用户扫描二维码，进行支付
     * 3、支付完成之后，微信服务器会通知支付成功
     * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
     */
    public function actionWxpay()
    {
        $data = Yii::$app->request->post();
        if (empty($data['member_id'])) {
            throw new BadRequestHttpException('缺失参数。');
        }
        $member_ids = explode(',', $data['member_id']);
        //查看将要购买的会员类型
        $course_categorys = Member::find()
        ->where(['id' => $member_ids])
        ->groupBy('course_category_id')
        ->all();
        if (empty($course_categorys)) {
            throw new BadRequestHttpException('会员不存在。');
        }
        $course_category_ids_arr = [];
        foreach ($course_categorys as $course_category_id) {
            $course_category_ids_arr[] = $course_category_id->course_category_id;
        }
        //已购买过的会员
        $member_orders = MemberGoods::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 2])
        ->andWhere(['>', 'end_time', time()])
        ->all();
        $buy_course_category_ids_str = '';
        foreach ($member_orders as $member_order) {
            $buy_course_category_ids_str .= $member_order->course_category_id . ',';
        }
        $buy_course_category_ids_arr = explode(',', $buy_course_category_ids_str);
        if (array_intersect($buy_course_category_ids_arr, $course_category_ids_arr)) {
            //订单已存在
            throw new BadRequestHttpException('你购买相关会员了,请不要重复购买。');
        }
        $member_id_str = '';
        $course_category_id_str = '';
        $member_name = '';
        $order_amount = 0.00;
        foreach($course_categorys as $course_category) {
            $member_name .= $course_category->content . ' ';
            $order_amount += $course_category->discount;
        }
        //添加订单信息
        $order_info = new MemberOrder();
        $order_info->order_sn = $data['order_sn'];
        $order_info->user_id = Yii::$app->user->id;
        $order_info->order_status = 1;
        $order_info->pay_status = 0;
        $order_info->consignee = Yii::$app->user->identity->username;
        $order_info->mobile = Yii::$app->user->identity->phone;
        $order_info->email = Yii::$app->user->identity->email;
        //0 1支付宝 2 微信
        $order_info->pay_id = 1;
        $order_info->pay_name = '支付宝';
        $order_info->goods_amount = $order_amount;
        $order_info->order_amount = $order_amount;
        $order_info->add_time = time();
        $order_info->save(false);
        foreach($course_categorys as $course_category) {
            $member_goods_model = new MemberGoods();
            $member_goods_model->user_id = Yii::$app->user->id;
            $member_goods_model->order_sn = $data['order_sn'];
            $member_goods_model->member_id = $course_category->id;
            $member_goods_model->course_category_id = $course_category->course_category_id;
            $member_goods_model->member_name = $course_category->name;
            $member_goods_model->price = $course_category->price;
            $member_goods_model->discount = $course_category->discount;
            $member_goods_model->add_time = time();
            $member_goods_model->end_time = time() + $course_category->time_period * 3600 * 24;
            $member_goods_model->pay_status = 0;
            $member_goods_model->save();
        }
        
        if (!empty($order_info)) {
            $notify = new \NativePay();
            $url1 = $notify->GetPrePayUrl($order_info->order_sn);
    
            $input = new \WxPayUnifiedOrder();
            $input->SetBody(trim('课程购买订单：'.$order_info->order_sn));
            $input->SetAttach($order_info->order_sn);
            $input->SetOut_trade_no($order_info->order_sn);
            $input->SetTotal_fee($order_info->order_amount * 100);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            //             $input->SetGoods_tag("test");
            //获取配置信息
            $config = Yii::$app->params['wxpay'];
            $input->SetNotify_url($config['notify_url']);
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id($order_info->order_sn);
            $result = $notify->GetPayUrl($input);
            
            if ($result['return_code'] == 'SUCCESS') {
                if ($result['result_code'] == 'SUCCESS') {
                    $url2 = self::qrcode($result["code_url"], 'wxpay.png');
                    return $this->render('wxpay', ['code_url' => $url2, 'out_trade_no' => $order_info->order_sn]);
                } else {
                    $return_msg = $result['err_code'] . ':' . $result['err_code_des'];
                    error_log($return_msg);
                    return $this->render('wxpay', ['return_msg' => $return_msg]);
                }
            } else {
                $return_msg = $result['result_code'].':'.$result['return_msg'];
                error_log($return_msg);
                return $this->render('wxpay', ['return_msg' => $return_msg]);
            }
    
        }
    
    
    }
    
    public function actionWxnotify()
    {
        error_log('file:'.__FILE__.'  line:'.__LINE__);
        //获取通知的数据
        $xml = Yii::$app->request->getRawBody();
        error_log('file:'.__FILE__.'  line:'.__LINE__.'   xml:'.$xml);
        //如果返回成功则验证签名
        //try {
        $result = $this->fromXml($xml);
        if($result['return_code'] == 'SUCCESS')
        {
            $sign = $this->sign($result);
            if($sign == $result['sign'])
            {
                if ($result['result_code'] == 'SUCCESS') {
                    //商户订单号
                    $out_trade_no = $result['out_trade_no'];
                    //微信支付订单号
                    $transaction_id = $result['transaction_id'];
                    //交易类型
                    $trade_type = $result['trade_type'];
                    //支付金额(单位：分)
                    $total_fee = $result['total_fee']/100.00;
                    //支付完成时间
                    $time_end = $result['time_end'];
    
    
                    $order_info = MemberOrder::find()
                    ->where(['order_sn' => $out_trade_no])
                    ->andWhere(['order_status' => 1])
                    ->andWhere(['pay_status' => 0])
                    ->one();
    
                    if (!empty($order_info)) {
                        if ($order_info->order_amount == $total_fee) {
                            $order_info->pay_id = $transaction_id;
                            $order_info->pay_name = '微信支付';
                            $order_info->money_paid = $total_fee;
                            $order_info->pay_status = 2;
                            $order_info->pay_time = time();
                            $order_info->save(false);
                            MemberGoods::updateAll(['pay_status' => 2], ['order_sn' => $out_trade_no]);
                        }
                    } else {
                        //订单状态已更新，直接返回
                        return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
                    }
                } else {
                    $return_msg = $result['err_code'].':'.$result['err_code_des'];
                    error_log($return_msg);
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        }
         
        public function actionWxcheckorder()
        {
            $data = Yii::$app->request->post();
             
            if(!empty($data["out_trade_no"])){
                $out_trade_no = $data["out_trade_no"];
                $input = new \WxPayOrderQuery();
                $input->SetOut_trade_no($out_trade_no);
                $result = \WxPayApi::orderQuery($input);
                if(array_key_exists("return_code", $result)
                    && array_key_exists("result_code", $result)
                    && $result["return_code"] == "SUCCESS"
                    && $result["result_code"] == "SUCCESS")
                {
                    //商户订单号
                    $out_trade_no = $result['out_trade_no'];
                    $order_info = MemberOrder::find()
                    ->where(['order_sn' => $out_trade_no])
                    ->andWhere(['order_status' => 1])
                    ->andWhere(['pay_status' => 0])
                    ->one();
                    if ($result['trade_state'] == "SUCCESS") {
                        
                        //微信支付订单号
                        $transaction_id = $result['transaction_id'];
                        //支付金额(单位：分)
                        $total_fee = $result['total_fee']/100.00;
                        //支付完成时间
                        $time_end = $result['time_end'];
    
                        if (!empty($order_info)) {
                            if ($order_info->order_amount == $total_fee) {
                                $order_info->pay_id = $transaction_id;
                                $order_info->pay_name = '微信支付';
                                $order_info->money_paid = $total_fee;
                                $order_info->pay_status = 2;
                                $order_info->pay_time = time();
                                $order_info->save(false);
                                MemberGoods::updateAll(['pay_status' => 2], ['order_sn' => $out_trade_no]);
                            }
                        }
                    } else if ($result['trade_state'] == "PAYERROR") {
                        //支付失败，取消订单
                        $order_info->pay_id = $transaction_id;
                        $order_info->pay_name = '微信支付';
                        $order_info->order_status = 2;
                        $order_info->pay_status = 0;
                        $order_info->invalid_time = time();
                        $order_info->save(false);
                    }
                }
    
                return json_encode($result);
            }
        }
         
        private function toXml($values)
        {
            if(!is_array($values) || count($values) <= 0)
            {
                throw new InvalidValueException("数组数据异常！");
            }
            //var_dump($values);exit;
            $xml = "<xml>";
            foreach ($values as $key=>$val)
            {
                if (is_numeric($val)){
                    $xml.="<".$key.">".$val."</".$key.">";
                }else{
                    $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
                     
                }
            }
            $xml.="</xml>";
            //echo $xml;exit;
            return $xml;
        }
         
        private function fromXml($xml)
        {
            if(!$xml){
                throw new InvalidValueException("xml数据异常！");
            }
            try
            {
                $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
            }
            catch(\Exception $e)
            {
                throw new InvalidValueException("xml数据异常！");
            }
            return $values;
        }
         
        public function sign($values)
        {
            ksort($values);
            $string = "";
            foreach ($values as $k => $v)
            {
                if($k != "sign" && $v != "" && !is_array($v)){
                    $string .= $k . "=" . $v . "&";
                }
            }
             
            $string = trim($string, "&");
            $string = $string . "&key=".$this->key;
            $string = md5($string);
            return strtoupper($string);
        }
    
        public static function qrcode($url, $name)
        {
            $qrCode = (new QrCode($url))
            ->setSize(250)
            ->setMargin(5)
            ->useForegroundColor(51, 153, 255);
            return $qrCode->writeDataUri();
        }
}
