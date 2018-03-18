<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[AudioSection]].
 *
 * @see AudioSection
 */
class AudioSectionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AudioSection[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AudioSection|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
