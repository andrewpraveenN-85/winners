<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form of `backend\models\User`.
 */
class UserSearch extends User {

    public $role;
    
    public function rules() {
        return [
            [['id', 'status',], 'integer'],
            [['email', 'role',], 'safe'],
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
        $query = User::find()
                ->alias('login')
                ->joinWith(['auth_assignment as assignment']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['status'] = [
            'asc' => [new \yii\db\Expression("FIELD(login.status, " . User::STATUS_ACTIVE . ", " . User::STATUS_INACTIVE . ", " . User::STATUS_DELETED . ")")],
            'desc' => [new \yii\db\Expression("FIELD(login.status, " . User::STATUS_DELETED . ", " . User::STATUS_INACTIVE . ", " . User::STATUS_ACTIVE . ")")],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['assignment.item_name' => $this->role]);

        return $dataProvider;
    }
}
