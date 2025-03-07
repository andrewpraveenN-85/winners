<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "draws".
 *
 * @property int $id
 * @property int $package_id
 * @property string $date_time
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Gifts[] $gifts
 * @property Packages $package
 */
class Draws extends \yii\db\ActiveRecord {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public static function tableName() {
        return 'draws';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules() {
        return [
            [['package_id', 'date_time', 'status',], 'required'],
            [['package_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['date_time'], 'safe'],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::class, 'targetAttribute' => ['package_id' => 'id']],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'package_id' => 'Package',
            'date_time' => 'Date Time',
            'status' => 'Status',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    public function getGifts() {
        return $this->hasMany(Gifts::class, ['draw_id' => 'id']);
    }

    public function getPackage() {
        return $this->hasOne(Packages::class, ['id' => 'package_id']);
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
