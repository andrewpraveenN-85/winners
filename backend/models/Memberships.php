<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "memberships".
 *
 * @property int $profile_id
 * @property int $package_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Packages $package
 * @property Profiles $profile
 */
class Memberships extends \yii\db\ActiveRecord {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    
    public static function tableName() {
        return 'memberships';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }
    
    public function rules() {
        return [
            [['profile_id', 'package_id', 'status'], 'required'],
            [['profile_id', 'package_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['profile_id', 'package_id'], 'unique', 'targetAttribute' => ['profile_id', 'package_id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::class, 'targetAttribute' => ['package_id' => 'id']],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels() {
        return [
            'profile_id' => 'Profile',
            'package_id' => 'Package',
            'status' => 'Status',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    public function getPackage() {
        return $this->hasOne(Packages::class, ['id' => 'package_id']);
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class, ['id' => 'profile_id']);
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
