<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[AudioCategory]].
 *
 * @see AudioCategory
 */
class AudioCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AudioCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AudioCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
