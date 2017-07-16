<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[FriendlyLinks]].
 *
 * @see FriendlyLinks
 */
class FriendlyLinksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FriendlyLinks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FriendlyLinks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
