<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Audio]].
 *
 * @see Audio
 */
class AudioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Audio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Audio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
