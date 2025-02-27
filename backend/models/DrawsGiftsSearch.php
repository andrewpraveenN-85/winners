<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DrawsGifts;

/**
 * DrawsGiftsSearch represents the model behind the search form of `backend\models\DrawsGifts`.
 */
class DrawsGiftsSearch extends DrawsGifts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'draws_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['gift_name'], 'safe'],
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
        $query = DrawsGifts::find();

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
            'draws_id' => $this->draws_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'gift_name', $this->gift_name]);

        return $dataProvider;
    }
}
