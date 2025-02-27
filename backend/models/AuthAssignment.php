<?php

namespace backend\models;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property int $user_id
 * @property int $created_at
 */
class AuthAssignment extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'auth_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['item_name', 'user_id'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['item_name'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
        ];
    }
}
