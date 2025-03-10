<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "winners".
 *
 * @property int $profile_id
 * @property int $draw_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Gifts $draw
 * @property Profiles $profile
 */
class Winners extends \yii\db\ActiveRecord {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public static function tableName() {
        return 'winners';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }
    
    public function rules() {
        return [
            [['profile_id', 'draw_id', 'status', 'created_at', 'updated_at'], 'required'],
            [['profile_id', 'draw_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['profile_id', 'draw_id'], 'unique', 'targetAttribute' => ['profile_id', 'draw_id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
            [['draw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Draws::class, 'targetAttribute' => ['draw_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'profile_id' => 'Member',
            'draw_id' => 'Draw',
            'status' => 'Status',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    public function getDraw() {
        return $this->hasOne(Draws::class, ['id' => 'draw_id']);
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class, ['id' => 'profile_id']);
    }
}
