<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Ad]].
 *
 * @see Ad
 */
class AdQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Ad[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Ad|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
