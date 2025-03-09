<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Profiles;
use backend\models\User;

class ProfilesSearch extends Profiles {

    public function rules() {
        return [
            [['id', 'user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'sin', 'mobile', 'dob', 'gender', 'dor', 'address', 'notes', 'img'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = Profiles::find()
        ->joinWith(['user' => function ($query) {
                $query->from(['user' => User::tableName()]);  // Alias the `users` table as `user`
            }]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['status'] = [
            'asc' => [new \yii\db\Expression("FIELD(status, " . User::STATUS_ACTIVE . ", " . User::STATUS_INACTIVE . ", " . User::STATUS_DELETED . ")")],
            'desc' => [new \yii\db\Expression("FIELD(status, " . User::STATUS_DELETED . ", " . User::STATUS_INACTIVE . ", " . User::STATUS_ACTIVE . ")")],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'middle_name', $this->middle_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'sin', $this->sin]);

        return $dataProvider;
    }
}
