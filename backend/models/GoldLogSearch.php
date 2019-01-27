<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GoldLog;

/**
 * GoldLogSearch represents the model behind the search form of `backend\models\GoldLog`.
 */
class GoldLogSearch extends GoldLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'user_type', 'operation_type', 'operation_time'], 'integer'],
            [['point', 'gold_balance'], 'number'],
            [['operation_detail'], 'safe'],
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
        $query = GoldLog::find();

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
            'userid' => $this->userid,
            'user_type' => $this->user_type,
            'point' => $this->point,
            'gold_balance' => $this->gold_balance,
            'operation_type' => $this->operation_type,
            'operation_time' => $this->operation_time,
        ]);

        $query->andFilterWhere(['like', 'operation_detail', $this->operation_detail]);

        return $dataProvider;
    }
}
