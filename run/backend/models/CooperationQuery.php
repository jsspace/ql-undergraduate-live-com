<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Cooperation]].
 *
 * @see Cooperation
 */
class CooperationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Cooperation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Cooperation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
