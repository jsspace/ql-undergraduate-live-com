<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Course;

/**
 * CourseSearch represents the model behind the search form about `backend\models\Course`.
 */
class CourseSearch extends Course
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'teacher_id', 'view', 'collection', 'share', 'online', 'create_time', 'examination_time', 'type'], 'integer'],
            [['course_name', 'list_pic', 'home_pic', 'category_name', 'des', 'head_teacher'], 'safe'],
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
        $query = Course::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
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
            'teacher_id' => $this->teacher_id,
            'price' => $this->price,
            'discount' => $this->discount,
            'view' => $this->view,
            'collection' => $this->collection,
            'share' => $this->share,
            'online' => $this->online,
            'onuse' => $this->onuse,
            'create_time' => $this->create_time,
            'examination_time' => $this->examination_time,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'course_name', $this->course_name])
            ->andFilterWhere(['like', 'list_pic', $this->list_pic])
            ->andFilterWhere(['like', 'home_pic', $this->home_pic])
            ->andFilterWhere(['like', 'category_name', $this->category_name])
            ->andFilterWhere(['like', 'des', $this->des])
            ->andFilterWhere(['like', 'head_teacher', $this->head_teacher]);

        return $dataProvider;
    }
}
