<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Read;
use backend\models\Message;

/**
 * ReadSearch represents the model behind the search form about `backend\models\Read`.
 */
class ReadSearch extends Read
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'msg_id', 'userid', 'status', 'read_time', 'get_time'], 'integer'],
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
        $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if(!array_key_exists('admin',$roles_array)) {
            //获取所有该市场专员发送的消息id
            $msgids = Message::find()
            ->select('msg_id')
            ->where(['publisher' => Yii::$app->user->id])
            ->asArray()
            ->all();
            $query = Read::find()
            ->where(['msg_id' => $msgids]);
        } else {
            $query = Read::find();
        }
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
            'msg_id' => $this->msg_id,
            'userid' => $this->userid,
            'status' => $this->status,
            'read_time' => $this->read_time,
            'get_time' => $this->get_time,
        ]);

        return $dataProvider;
    }
}
