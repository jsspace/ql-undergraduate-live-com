<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ShandongSchool]].
 *
 * @see ShandongSchool
 */
class ShandongSchoolQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ShandongSchool[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShandongSchool|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
