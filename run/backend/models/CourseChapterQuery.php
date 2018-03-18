<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[CourseChapter]].
 *
 * @see CourseChapter
 */
class CourseChapterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CourseChapter[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CourseChapter|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
