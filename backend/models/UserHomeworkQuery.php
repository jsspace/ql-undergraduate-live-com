<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[UserHomework]].
 *
 * @see UserHomework
 */
class UserHomeworkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserHomework[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserHomework|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
