<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AdminSession;

/**
 * AdminSessionSearch represents the model behind the search form of `backend\models\AdminSession`.
 */
class AdminSessionSearch extends AdminSession
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_id', 'id'], 'integer'],
            [['session_token'], 'safe'],
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
        $query = AdminSession::find();

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
            'session_id' => $this->session_id,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'session_token', $this->session_token]);

        return $dataProvider;
    }
}
