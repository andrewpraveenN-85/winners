<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Merchants;

/**
 * MerchantsSearch represents the model behind the search form of `backend\models\Merchants`.
 */
class MerchantsSearch extends Merchants {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'bussiness_name', 'last_name', 'brn', 'mobile', 'dor', 'type', 'address', 'notes', 'img'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Merchants::find();

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

        ]);

        $query->andFilterWhere(['like', 'bussiness_name', $this->bussiness_name]);

        return $dataProvider;
    }
}
