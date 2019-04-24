<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Message;

/**
 * MessageSearch represents the model behind the search form of `backend\models\Message`.
 */
class MessageSearch extends Message
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'add_time', 'admin_id', 'reply_time'], 'integer'],
            [['message', 'reply'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Message::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>["pageSize"=>5],
            'sort'  => [                        // sort 用于排序
                'defaultOrder' => [
                    'status' => SORT_ASC,          // defaultOrder 指定默认排序字段
                    'id' => SORT_DESC,          // defaultOrder 指定默认排序字段
                ],
            ],
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
            'user_id' => $this->user_id,
            'add_time' => $this->add_time,
            'admin_id' => $this->admin_id,
            'reply_time' => $this->reply_time,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'reply', $this->reply]);

        return $dataProvider;
    }
}
