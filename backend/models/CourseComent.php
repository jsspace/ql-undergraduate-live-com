<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_coment}}".
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $user_id
 * @property string $content
 * @property integer $check
 * @property integer $create_time
 */
class CourseComent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_coment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'user_id', 'content', 'check'], 'required'],
            [['course_id', 'user_id', 'check', 'create_time'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_id' => Yii::t('app', '对应课程的id'),
            'user_id' => Yii::t('app', '评论用户的id'),
            'content' => Yii::t('app', '评价内容'),
            'check' => Yii::t('app', '审查是否通过'),
            'create_time' => Yii::t('app', '评论时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return CourseComentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseComentQuery(get_called_class());
    }
}
