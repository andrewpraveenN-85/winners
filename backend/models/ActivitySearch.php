<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Activity;

/**
 * ActivitySearch represents the model behind the search form of `backend\models\Activity`.
 */
class ActivitySearch extends Activity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'event_id'], 'integer'],
            [['check_in', 'check_out', 'notes'], 'safe'],
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
        $query = Activity::find();

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
            'profile_id' => $this->profile_id,
            'event_id' => $this->event_id,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
