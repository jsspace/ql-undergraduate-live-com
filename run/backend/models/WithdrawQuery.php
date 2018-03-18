<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Withdraw]].
 *
 * @see Withdraw
 */
class WithdrawQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Withdraw[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Withdraw|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
