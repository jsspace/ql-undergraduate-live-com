<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%recommend}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $pic
 * @property string $content
 * @property string $course_id
 * @property integer $create_time
 */
class Recommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recommend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'pic', 'content'], 'required'],
            [['content'], 'string'],
            [['create_time'], 'integer'],
            [['title', 'pic', 'course_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '推荐题目'),
            'pic' => Yii::t('app', '推荐文的pic'),
            'content' => Yii::t('app', '推荐软文'),
            'course_id' => Yii::t('app', '关联的课程的id'),
            'create_time' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return RecommendQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RecommendQuery(get_called_class());
    }
}
