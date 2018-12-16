<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[CourseSectionPoints]].
 *
 * @see CourseSectionPoints
 */
class CourseSectionPointsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CourseSectionPoints[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CourseSectionPoints|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
