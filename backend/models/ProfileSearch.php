<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Profile;

/**
 * ProfileSearch represents the model behind the search form of `backend\models\Profile`.
 */
class ProfileSearch extends Profile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'draw_eligible_count', 'reward_participation', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'sin', 'email', 'mobile', 'dob', 'gender', 'proffetion', 'address', 'location', 'membership', 'shopping_preferences_Behavior', 'favorite_categories', 'profile_img', 'qr_img'], 'safe'],
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
        $query = Profile::find();

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
            'dob' => $this->dob,
            'draw_eligible_count' => $this->draw_eligible_count,
            'reward_participation' => $this->reward_participation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'sin', $this->sin])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'proffetion', $this->proffetion])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'membership', $this->membership])
            ->andFilterWhere(['like', 'shopping_preferences_Behavior', $this->shopping_preferences_Behavior])
            ->andFilterWhere(['like', 'favorite_categories', $this->favorite_categories])
            ->andFilterWhere(['like', 'profile_img', $this->profile_img])
            ->andFilterWhere(['like', 'qr_img', $this->qr_img]);

        return $dataProvider;
    }
}
