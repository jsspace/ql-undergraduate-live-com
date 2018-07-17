<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SectionPractice;

/**
 * SectionPracticeSearch represents the model behind the search form of `backend\models\SectionPractice`.
 */
class SectionPracticeSearch extends SectionPractice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'section_id', 'course_id', 'create_time'], 'integer'],
            [['title', 'problem_des', 'answer'], 'safe'],
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
        $query = SectionPractice::find();

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
            'section_id' => $this->section_id,
            'course_id' => $this->course_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'problem_des', $this->problem_des])
            ->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
