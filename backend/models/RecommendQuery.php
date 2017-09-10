<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Recommend]].
 *
 * @see Recommend
 */
class RecommendQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Recommend[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Recommend|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
