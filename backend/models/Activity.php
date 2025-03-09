<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property int $profile_id
 * @property int $event_id
 *
 * @property Events $event
 * @property Profiles $profile
 */
class Activity extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'activity';
    }

    public function rules() {
        return [
            [['profile_id', 'event_id',], 'required'],
            [['profile_id', 'event_id'], 'integer'],
            [['profile_id', 'event_id'], 'unique', 'targetAttribute' => ['profile_id', 'event_id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::class, 'targetAttribute' => ['event_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'profile_id' => 'Profile',
            'event_id' => 'Event',
        ];
    }

    public function getEvent() {
        return $this->hasOne(Events::class, ['id' => 'event_id']);
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class, ['id' => 'profile_id']);
    }
}
