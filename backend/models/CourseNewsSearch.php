<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CourseNews;

/**
 * CourseNewsSearch represents the model behind the search form about `backend\models\CourseNews`.
 */
class CourseNewsSearch extends CourseNews
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'onuse', 'position', 'view'], 'integer'],
            [['title', 'list_pic', 'des', 'courseid'], 'safe'],
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
        $query = CourseNews::find();

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
            'onuse' => $this->onuse,
            'position' => $this->position,
            'view' => $this->view,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'list_pic', $this->list_pic])
            ->andFilterWhere(['like', 'des', $this->des])
            ->andFilterWhere(['like', 'courseid', $this->courseid]);

        return $dataProvider;
    }
}
