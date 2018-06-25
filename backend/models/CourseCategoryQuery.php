<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[CourseCategory]].
 *
 * @see CourseCategory
 */
class CourseCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CourseCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CourseCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
