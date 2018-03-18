<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[MemberOrder]].
 *
 * @see MemberOrder
 */
class MemberOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MemberOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MemberOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
