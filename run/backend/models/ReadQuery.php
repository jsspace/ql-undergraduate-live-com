<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Read]].
 *
 * @see Read
 */
class ReadQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Read[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Read|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
