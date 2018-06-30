<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CourseSection;

/**
 * CourseSectionSearch represents the model behind the search form about `backend\models\CourseSection`.
 */
class CourseSectionSearch extends CourseSection
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['id', 'course_id', 'position', 'type', 'paid_free'], 'integer'],
          [['name', 'start_time', 'video_url', 'duration', 'playback_url'], 'safe'],
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
        $query = CourseSection::find();

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
            'position' => $this->position,
            'type' => $this->type,
            'start_time' => $this->start_time,
            'paid_free' => $this->paid_free, 
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'video_url', $this->video_url])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'playback_url', $this->playback_url]);

        return $dataProvider;
    }
}
