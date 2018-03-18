<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[UserStudyLog]].
 *
 * @see UserStudyLog
 */
class UserStudyLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserStudyLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserStudyLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
