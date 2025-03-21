<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Packages;

/**
 * PackagesSearch represents the model behind the search form of `backend\models\Packages`.
 */
class PackagesSearch extends Packages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entry_point', 'smart_saving_events', 'status', 'merchants_discount','created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'duration'], 'safe'],
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
        $query = Packages::find();

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
            'entry_point' => $this->entry_point,
            'smart_saving_events' => $this->smart_saving_events,
            'status' => $this->status,
            'merchants_discount' => $this->merchants_discount,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'duration', $this->duration]);

        return $dataProvider;
    }
}
