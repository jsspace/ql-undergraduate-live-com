<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[MemberGoods]].
 *
 * @see MemberGoods
 */
class MemberGoodsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MemberGoods[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MemberGoods|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
