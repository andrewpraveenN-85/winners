<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Merchant;

/**
 * MerchantSearch represents the model behind the search form of `backend\models\Merchant`.
 */
class MerchantSearch extends Merchant
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['bussiness_name', 'address', 'location', 'owner_name', 'owner_contact_no', 'manager_name', 'manager_contact_no', 'business_category', 'bussiness_logo', 'qr_img'], 'safe'],
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
        $query = Merchant::find();

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
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'bussiness_name', $this->bussiness_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'owner_name', $this->owner_name])
            ->andFilterWhere(['like', 'owner_contact_no', $this->owner_contact_no])
            ->andFilterWhere(['like', 'manager_name', $this->manager_name])
            ->andFilterWhere(['like', 'manager_contact_no', $this->manager_contact_no])
            ->andFilterWhere(['like', 'business_category', $this->business_category])
            ->andFilterWhere(['like', 'bussiness_logo', $this->bussiness_logo])
            ->andFilterWhere(['like', 'qr_img', $this->qr_img]);

        return $dataProvider;
    }
}
