<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserHomework;

/**
 * UserHomeworkSearch represents the model behind the search form of `backend\models\UserHomework`.
 */
class UserHomeworkSearch extends UserHomework
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'section_id', 'status', 'user_id'], 'integer'],
            [['pic_url', 'submit_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserHomework::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'course_id' => $this->course_id,
            'section_id' => $this->section_id,
            'status' => $this->status,
            'submit_time' => $this->submit_time,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'pic_url', $this->pic_url]);

        return $dataProvider;
    }

    public function totalsearch($params)
    {
        $query = UserHomework::find()
            ->groupBy(['user_id', 'course_id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }

}
