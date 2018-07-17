<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[SectionPractice]].
 *
 * @see SectionPractice
 */
class SectionPracticeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SectionPractice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SectionPractice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
