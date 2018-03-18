<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[UserOld]].
 *
 * @see UserOld
 */
class UserOldQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserOld[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserOld|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
