<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * StudentSearch represents the model behind the search form about `backend\models\User`.
 */
class StudentSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'gender', 'invite', 'schoolid'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'phone', 'description', 'unit', 'office', 'goodat', 'picture', 'intro', 'wechat', 'wechat_img', 'provinceid', 'cityid'], 'safe'],
            [['percentage'], 'number'],
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
        $user_ids = Yii::$app->authManager->getUserIdsByRole('student');
        $query = User::find()
        ->where(['in', 'id', $user_ids]);

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'gender' => $this->gender,
            'invite' => $this->invite,
            'percentage' => $this->percentage,
            'schoolid' => $this->schoolid
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'provinceid', $this->provinceid])
            ->andFilterWhere(['like', 'cityid', $this->cityid])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'office', $this->office])
            ->andFilterWhere(['like', 'goodat', $this->goodat])
            ->andFilterWhere(['like', 'picture', $this->picture])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'wechat_img', $this->wechat_img]);

        return $dataProvider;
    }
}
