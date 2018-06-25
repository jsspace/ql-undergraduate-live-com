<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MemberGoods;

/**
 * MemberGoodsSearch represents the model behind the search form about `backend\models\MemberGoods`.
 */
class MemberGoodsSearch extends MemberGoods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rec_id', 'user_id', 'member_id', 'course_category_id', 'add_time', 'end_time', 'pay_status'], 'integer'],
            [['order_sn', 'member_name'], 'safe'],
            [['price', 'discount'], 'number'],
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
        $query = MemberGoods::find();

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
            'user_id' => $this->user_id,
            'member_id' => $this->member_id,
            'course_category_id' => $this->course_category_id,
            'price' => $this->price,
            'discount' => $this->discount,
            'add_time' => $this->add_time,
            'end_time' => $this->end_time,
            'pay_status' => $this->pay_status,
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'member_name', $this->member_name]);

        return $dataProvider;
    }
}
