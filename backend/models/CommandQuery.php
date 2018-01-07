<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Command]].
 *
 * @see Command
 */
class CommandQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Command[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Command|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
