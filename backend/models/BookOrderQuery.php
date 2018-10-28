<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[BookOrder]].
 *
 * @see BookOrder
 */
class BookOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BookOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BookOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
