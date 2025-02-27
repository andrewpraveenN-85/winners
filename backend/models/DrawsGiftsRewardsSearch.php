<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DrawsGiftsRewards;

/**
 * DrawsGiftsRewardsSearch represents the model behind the search form of `backend\models\DrawsGiftsRewards`.
 */
class DrawsGiftsRewardsSearch extends DrawsGiftsRewards
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['draws_gift_id', 'rewards_id'], 'integer'],
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
        $query = DrawsGiftsRewards::find();

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
            'draws_gift_id' => $this->draws_gift_id,
            'rewards_id' => $this->rewards_id,
        ]);

        return $dataProvider;
    }
}
