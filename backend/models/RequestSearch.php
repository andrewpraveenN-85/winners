<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Request;

/**
 * RequestSearch represents the model behind the search form of `common\models\Request`.
 */
class RequestSearch extends Request {

    public $categoryName;
    public $userName;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['message', 'comments', 'categoryName', 'userName'], 'safe'],
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
        $query = Request::find()->joinWith(['user', 'categories']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['userName'] = [
            'asc' => ['users.name' => SORT_ASC],
            'desc' => ['users.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['categoryName'] = [
            'asc' => ['categorys.name' => SORT_ASC],
            'desc' => ['categorys.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['status'] = [
            'asc' => [new \yii\db\Expression("FIELD(status, " . Request::STATUS_NEW . ", " . Request::STATUS_PROGRESS . ", " . Request::STATUS_CLOSED . ", " . Request::STATUS_DELETED . ")")],
            'desc' => [new \yii\db\Expression("FIELD(status, " . Request::STATUS_DELETED . ", " . Request::STATUS_CLOSED . ", " . Request::STATUS_PROGRESS . ", " . Request::STATUS_NEW . ")")],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'category_id' => $this->categoryName,
            'request.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message])
                ->andFilterWhere(['like', 'comments', $this->comments])
                ->andFilterWhere(['like', 'user.name', $this->userName]);

        if ($this->created_at) {
            $dateStart = strtotime($this->created_at . ' 00:00:00');
            $dateEnd = strtotime($this->created_at . ' 23:59:59');
            $query->andFilterWhere(['between', 'purchase_orders.created_at', $dateStart, $dateEnd]);
        }

        return $dataProvider;
    }
}
