<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[CoursePackage]].
 *
 * @see CoursePackage
 */
class CoursePackageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CoursePackage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CoursePackage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
