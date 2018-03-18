<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[AdminSession]].
 *
 * @see AdminSession
 */
class AdminSessionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AdminSession[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdminSession|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
