<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $address
 * @property string $date_time
 * @property string $registration_deadline
 * @property int $maximum_participations
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Activity[] $activities
 * @property Profiles[] $profiles
 */
class Events extends \yii\db\ActiveRecord {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public static function tableName() {
        return 'events';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules() {
        return [
            [['name', 'address', 'date_time', 'registration_deadline', 'status'], 'required'],
            [['description'], 'string'],
            [['description', 'registration_deadline', 'maximum_participations'], 'safe'],
            [['maximum_participations', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'address' => 'Address',
            'date_time' => 'Date Time',
            'registration_deadline' => 'Registration Deadline',
            'maximum_participations' => 'Maximum Participations',
            'status' => 'Status',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    public function getActivities() {
        return $this->hasMany(Activity::class, ['event_id' => 'id']);
    }

    public function getProfiles() {
        return $this->hasMany(Profiles::class, ['id' => 'profile_id'])->viaTable('activity', ['event_id' => 'id']);
    }

    public function getStatusText() {
        if ($this->status == self::STATUS_ACTIVE) {
            return 'ACTIVE';
        }
        if ($this->status == self::STATUS_INACTIVE) {
            return 'INACTIVE';
        }
        if ($this->status == self::STATUS_DELETED) {
            return 'DELETED';
        }
    }
}
