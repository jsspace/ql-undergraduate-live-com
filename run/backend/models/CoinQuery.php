<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Coin]].
 *
 * @see Coin
 */
class CoinQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Coin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Coin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
