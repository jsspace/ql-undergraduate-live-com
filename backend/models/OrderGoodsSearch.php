<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderGoods;

/**
 * OrderGoodsSearch represents the model behind the search form about `backend\models\OrderGoods`.
 */
class OrderGoodsSearch extends OrderGoods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rec_id', 'order_id', 'goods_id', 'goods_number', 'send_number', 'is_real', 'parent_id', 'is_gift'], 'integer'],
            [['goods_name', 'goods_sn', 'goods_attr', 'extension_code'], 'safe'],
            [['market_price', 'goods_price'], 'number'],
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
        $query = OrderGoods::find();

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
            'rec_id' => $this->rec_id,
            'order_id' => $this->order_id,
            'goods_id' => $this->goods_id,
            'goods_number' => $this->goods_number,
            'market_price' => $this->market_price,
            'goods_price' => $this->goods_price,
            'send_number' => $this->send_number,
            'is_real' => $this->is_real,
            'parent_id' => $this->parent_id,
            'is_gift' => $this->is_gift,
        ]);

        $query->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'goods_sn', $this->goods_sn])
            ->andFilterWhere(['like', 'goods_attr', $this->goods_attr])
            ->andFilterWhere(['like', 'extension_code', $this->extension_code]);

        return $dataProvider;
    }
}
