<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CourseSectionPoints;

/**
 * CourseSectionPointsSearch represents the model behind the search form of `backend\models\CourseSectionPoints`.
 */
class CourseSectionPointsSearch extends CourseSectionPoints
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'position', 'type', 'section_id'], 'integer'],
            [['name', 'start_time', 'explain_video_url', 'video_url', 'roomid', 'duration', 'playback_url', 'paid_free'], 'safe'],
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
        $query = CourseSectionPoints::find();

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
            'position' => $this->position,
            'type' => $this->type,
            'start_time' => $this->start_time,
            'section_id' => $this->section_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'explain_video_url', $this->explain_video_url])
            ->andFilterWhere(['like', 'video_url', $this->video_url])
            ->andFilterWhere(['like', 'roomid', $this->roomid])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'playback_url', $this->playback_url])
            ->andFilterWhere(['like', 'paid_free', $this->paid_free]);

        return $dataProvider;
    }
}
