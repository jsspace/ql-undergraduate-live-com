<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Quas;

/**
 * QuasSearch represents the model behind the search form about `backend\models\Quas`.
 */
class QuasSearch extends Quas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'teacher_id', 'question_time', 'answer_time', 'course_id', 'check'], 'integer'],
            [['question', 'answer'], 'safe'],
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
        $query = Quas::find();

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
            'student_id' => $this->student_id,
            'teacher_id' => $this->teacher_id,
            'question_time' => $this->question_time,
            'answer_time' => $this->answer_time,
            'course_id' => $this->course_id,
            'check' => $this->check,
        ]);

        $query->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer]);

        $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if(!array_key_exists('admin',$roles_array)) {
            $query->andFilterWhere(['teacher_id' => Yii::$app->user->id]);
        }

        return $dataProvider;
    }
}
