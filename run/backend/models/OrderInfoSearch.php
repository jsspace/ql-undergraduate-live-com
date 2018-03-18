<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderInfo;

/**
 * OrderInfoSearch represents the model behind the search form about `backend\models\OrderInfo`.
 */
class OrderInfoSearch extends OrderInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'order_status', 'pay_status', 'integral', 'add_time', 'confirm_time', 'pay_time', 'bonus_id', 'is_separate', 'parent_id', 'invalid_time'], 'integer'],
            [['order_sn', 'consignee', 'mobile', 'email', 'pay_id', 'pay_name', 'course_ids', 'coupon_ids'], 'safe'],
            [['goods_amount', 'pay_fee', 'money_paid', 'integral_money', 'bonus', 'order_amount', 'discount', 'coupon_money'], 'number'],
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
        $query = OrderInfo::find();

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
            'order_status' => $this->order_status,
            'pay_status' => $this->pay_status,
            'goods_amount' => $this->goods_amount,
            'pay_fee' => $this->pay_fee,
            'money_paid' => $this->money_paid,
            'integral' => $this->integral,
            'integral_money' => $this->integral_money,
            'bonus' => $this->bonus,
            'order_amount' => $this->order_amount,
            'add_time' => $this->add_time,
            'confirm_time' => $this->confirm_time,
            'pay_time' => $this->pay_time,
            'bonus_id' => $this->bonus_id,
            'is_separate' => $this->is_separate,
            'parent_id' => $this->parent_id,
            'discount' => $this->discount,
            'invalid_time' => $this->invalid_time,
            'coupon_money' => $this->coupon_money,
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'consignee', $this->consignee])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'pay_id', $this->pay_id])
            ->andFilterWhere(['like', 'pay_name', $this->pay_name])
            ->andFilterWhere(['like', 'course_ids', $this->course_ids])
            ->andFilterWhere(['like', 'coupon_ids', $this->coupon_ids]);
        $query->orderBy('order_id desc');
        
        return $dataProvider;
    }
}
