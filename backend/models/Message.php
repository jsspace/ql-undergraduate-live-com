<?php

namespace backend\models;
use backend\models\User;
use backend\models\OrderGoods;
use backend\models\read;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property string $msg_id
 * @property integer $publisher
 * @property string $content
 * @property string $title
 * @property string $classids
 * @property string $cityid
 * @property integer $status
 * @property integer $created_time
 * @property integer $publish_time
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'title'], 'required'],
            [['publisher', 'status', 'created_time', 'publish_time'], 'integer'],
            [['content'], 'string'],
            [['classids', 'title'], 'string', 'max' => 255],
            [['cityid'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'msg_id' => Yii::t('app', '消息id'),
            'publisher' => Yii::t('app', '消息发布者'),
            'content' => Yii::t('app', '内容'),
            'title' => Yii::t('app', '标题'),
            'classids' => Yii::t('app', '发送给'),
            'cityid' => Yii::t('app', '地级市'),
            'status' => Yii::t('app', '审核状态'),
            'created_time' => Yii::t('app', '消息创建时间'),
            'publish_time' => Yii::t('app', '消息发布时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return MessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessageQuery(get_called_class());
    }

    public static function getMessage($msg_id)
    {
        $model = self::find()
        ->where(['msg_id' => $msg_id])
        ->one();
        return $model;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $classIdsArr = $this->classids;
            /* 分割传过来的数组 */
            if($this->classids) {
                $this->classids = implode(',',$this->classids);
            }
            if ($insert) {
                $this->publisher = Yii::$app->user->id;
                $this->created_time = time();
                $isadmin = User::isAdmin(Yii::$app->user->id);
                if($isadmin == 1) {
                    $this->cityid = 'all';
                } else {
                    $this->cityid = User::getUserModel(Yii::$app->user->id)->cityid;
                }
            }
            /* 如果审核已通过，填充消息的发布时间并将消息保存到用户的系统消息表，初始状态为未读 */
            if ($this->status == 1) {
                $this->publish_time = time();
                $userIdArr = array();
                if (in_array('alluser', $classIdsArr)) {
                    $userNameIdArr = User::users('student');
                    $userIdArr = array_keys($userNameIdArr);
                } else if(in_array('allclass', $classIdsArr)) {
                    $orderGoods = OrderGoods::find()
                    ->select('user_id')
                    ->where(['type' => 'course_package'])
                    ->andWhere(['pay_status' => 2])
                    ->asArray()
                    ->all();
                    $userIdArr = array_column($orderGoods, 'user_id');
                } else {
                    $orderGoods = OrderGoods::find()
                    ->select('user_id')
                    ->where(['type' => 'course_package'])
                    ->andWhere(['pay_status' => 2])
                    ->andWhere(['goods_id' => $classIdsArr])
                    ->asArray()
                    ->all();
                    $userIdArr = array_column($orderGoods, 'user_id');
                }
                $userIdArr = array_unique($userIdArr);
                $isadmin = User::isAdmin($this->publisher);
                if(!$isadmin) {
                //市场专员身份发送信息
                    foreach ($userIdArr as $key => $userId) {
                        if (User::getUserModel($userId)->cityid != $this->cityid) {
                            unset($userIdArr[$key]);
                        }
                    }
                }
                /* 添加用户消息表 */
                foreach ($userIdArr as $key => $userId) {
                    $readModel = new Read();
                    $readModel->msg_id = $this->msg_id;
                    $readModel->userid = $userId;
                    $readModel->get_time = time();
                    $readModel->save(false);
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
