<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AudioSection;

/**
 * AudioSectionSearch represents the model behind the search form about `backend\models\AudioSection`.
 */
class AudioSectionSearch extends AudioSection
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'audio_id', 'click_time', 'collection', 'share', 'create_time'], 'integer'],
            [['audio_name', 'audio_author', 'audio_url'], 'safe'],
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
        $query = AudioSection::find();

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
            'audio_id' => $this->audio_id,
            'click_time' => $this->click_time,
            'collection' => $this->collection,
            'share' => $this->share,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'audio_name', $this->audio_name])
            ->andFilterWhere(['like', 'audio_author', $this->audio_author])
            ->andFilterWhere(['like', 'audio_url', $this->audio_url]);

        return $dataProvider;
    }
}
