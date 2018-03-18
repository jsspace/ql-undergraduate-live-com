<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Card]].
 *
 * @see Card
 */
class CardQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Card[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Card|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
