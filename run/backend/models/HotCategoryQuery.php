<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[HotCategory]].
 *
 * @see HotCategory
 */
class HotCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return HotCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HotCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
