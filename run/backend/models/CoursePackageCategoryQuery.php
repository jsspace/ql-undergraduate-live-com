<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[CoursePackageCategory]].
 *
 * @see CoursePackageCategory
 */
class CoursePackageCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CoursePackageCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CoursePackageCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
