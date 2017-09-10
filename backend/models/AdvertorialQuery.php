<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Advertorial]].
 *
 * @see Advertorial
 */
class AdvertorialQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Advertorial[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Advertorial|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
