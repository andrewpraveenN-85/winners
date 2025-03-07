<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Merchants;
use backend\models\User;

class MerchantsSearch extends Merchants {

    public function rules() {
        return [
            [['id', 'user_id', 'created_at', 'updated_at', 'status'], 'integer'], // Add status here
            [['first_name', 'bussiness_name', 'last_name', 'brn', 'mobile', 'dor', 'type', 'address', 'notes', 'img'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = Merchants::find()
        ->joinWith(['user' => function ($query) {
            $query->from(['user' => User::tableName()]);  // Alias the `users` table as `user`
        }]);

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
            'user.status' => $this->status,  // Reference status from the User model
        ]);

        $query->andFilterWhere(['like', 'bussiness_name', $this->bussiness_name])
              ->andFilterWhere(['like', 'brn', $this->brn])  ;

        return $dataProvider;
    }
    
    public function packageSearch($params) {
        $query = Merchants::find()
        ->joinWith(['user' => function ($query) {
            $query->from(['user' => User::tableName()]);  // Alias the `users` table as `user`
        }]);

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
            'user.status' => $this->status,  // Reference status from the User model
        ]);

        $query->andFilterWhere(['like', 'bussiness_name', $this->bussiness_name])
              ->andFilterWhere(['like', 'brn', $this->brn])  ;

        return $dataProvider;
    }
}
