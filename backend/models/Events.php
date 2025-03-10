<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property int $package_id
 * @property string $name
 * @property string $description
 * @property string $address
 * @property string $date_time
 * @property string|null $img
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

    public $image;

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
            [['package_id', 'name', 'address', 'date_time', 'status'], 'required'],
            [['description', 'image'], 'string'],
            [['description', 'image'], 'safe'],
            [['package_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::class, 'targetAttribute' => ['package_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'package_id' => 'Package',
            'name' => 'Name',
            'description' => 'Description',
            'address' => 'Address',
            'date_time' => 'Date Time',
            'status' => 'Status',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            'image' => 'Banner'
        ];
    }

    public function getPackage() {
        return $this->hasOne(Packages::class, ['id' => 'package_id']);
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

    public function getImgURL() {
        if ($this->img != null) {
            return Yii::$app->params['back_host'] . 'events/' . $this->img;
        } else {
            return Yii::$app->params['back_host'] . 'default.jpg';
        }
    }
}
