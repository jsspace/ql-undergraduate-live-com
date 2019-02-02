<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GoldOrderInfo;

/**
 * GoldOrderInfoSeach represents the model behind the search form of `backend\models\GoldOrderInfo`.
 */
class GoldOrderInfoSeach extends GoldOrderInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'gold_num', 'add_time', 'confirm_time', 'pay_time', 'invalid_time', 'gift_coins'], 'integer'],
            [['order_sn', 'order_status', 'pay_status', 'pay_id', 'pay_name'], 'safe'],
            [['pay_fee', 'money_paid', 'order_amount'], 'number'],
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
        $query = GoldOrderInfo::find();

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
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'gold_num' => $this->gold_num,
            'pay_fee' => $this->pay_fee,
            'money_paid' => $this->money_paid,
            'order_amount' => $this->order_amount,
            'add_time' => $this->add_time,
            'confirm_time' => $this->confirm_time,
            'pay_time' => $this->pay_time,
            'invalid_time' => $this->invalid_time,
            'gift_coins' => $this->gift_coins,
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'order_status', $this->order_status])
            ->andFilterWhere(['like', 'pay_status', $this->pay_status])
            ->andFilterWhere(['like', 'pay_id', $this->pay_id])
            ->andFilterWhere(['like', 'pay_name', $this->pay_name]);

        return $dataProvider;
    }
}
