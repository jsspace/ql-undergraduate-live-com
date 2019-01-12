<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CoursePackage;

/**
 * CoursePackageSearch represents the model behind the search form about `backend\models\CoursePackage`.
 */
class CoursePackageSearch extends CoursePackage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'view', 'collection', 'share', 'online', 'onuse', 'create_time', 'head_teacher'], 'integer'],
            [['name', 'course', 'list_pic', 'home_pic', 'des', 'intro'], 'safe'],
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
        $query = CoursePackage::find();

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
            'price' => $this->price,
            'discount' => $this->discount,
            'view' => $this->view,
            'collection' => $this->collection,
            'share' => $this->share,
            'online' => $this->online,
            'onuse' => $this->onuse,
            'create_time' => $this->create_time,
            'head_teacher' => $this->head_teacher,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'course', $this->course])
            ->andFilterWhere(['like', 'list_pic', $this->list_pic])
            ->andFilterWhere(['like', 'home_pic', $this->home_pic])
            ->andFilterWhere(['like', 'des', $this->des])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
