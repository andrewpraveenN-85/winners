<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Offers;

/**
 * OffersSearch represents the model behind the search form of `backend\models\Offers`.
 */
class OffersSearch extends Offers {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['package_id', 'merchant_id', 'discount'], 'integer'],
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
        $query = Offers::find();

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
            'package_id' => $this->package_id,
            'merchant_id' => $this->merchant_id,
        ]);

        return $dataProvider;
    }
}
