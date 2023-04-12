<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SendEvent;

/**
 * SendEventSearch represents the model behind the search form of `common\models\SendEvent`.
 */
class SendEventSearch extends SendEvent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['event_name', 'recipient_email', 'created_at', 'updated_at'], 'safe'],
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
        $query = SendEvent::find();

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

        if ($this->created_at){
            $begin_day = date('Y-m-d',strtotime($this->created_at)).' 00:00:00';
            $end_day = date('Y-m-d',strtotime($this->created_at)).' 23:59:59';
            $query->andFilterWhere(['between', 'created_at', $begin_day, $end_day]);
        }

        if ($this->updated_at){
            $begin_day = date('Y-m-d',strtotime($this->updated_at)).' 00:00:00';
            $end_day = date('Y-m-d',strtotime($this->updated_at)).' 23:59:59';
            $query->andFilterWhere(['between', 'updated_at', $begin_day, $end_day]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'event_name', $this->event_name])
            ->andFilterWhere(['like', 'recipient_email', $this->recipient_email]);

        return $dataProvider;
    }
}
