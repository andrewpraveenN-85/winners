<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "packages".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $duration
 * @property int $entry_point
 * @property int $smart_saving_events
 * @property int $merchants_discount
 * @property string|null $img
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Draws[] $draws
 * @property Memberships[] $memberships
 * @property Merchants[] $merchants
 * @property Offers[] $offers
 * @property Profiles[] $profiles
 */
class Packages extends \yii\db\ActiveRecord {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    
     public $image;
    
    public static function tableName() {
        return 'packages';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules() {
        return [
            [['name', 'duration', 'entry_point', 'smart_saving_events','merchants_discount', 'status'], 'required'],
            [['description', 'duration', 'image'], 'string'],
            [['description', 'image'], 'safe'],
            [['entry_point', 'smart_saving_events','merchants_discount', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'duration' => 'Duration',
            'entry_point' => 'Entry',
            'smart_saving_events' => 'Events',
            'eventText' => 'Events',
            'merchants_discount' => 'Discount %',
            'status' => 'Status',
            'statusText' => 'Status',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    public function getDraws() {
        return $this->hasMany(Draws::class, ['package_id' => 'id']);
    }

    public function getMemberships() {
        return $this->hasMany(Memberships::class, ['package_id' => 'id']);
    }

    public function getMerchants() {
        return $this->hasMany(Merchants::class, ['id' => 'merchant_id'])->viaTable('offers', ['package_id' => 'id']);
    }

    public function getOffers() {
        return $this->hasMany(Offers::class, ['package_id' => 'id']);
    }

    public function getProfiles() {
        return $this->hasMany(Profiles::class, ['id' => 'profile_id'])->viaTable('memberships', ['package_id' => 'id']);
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
    
    public function getEventText() {
        if ($this->smart_saving_events == 1) {
            return 'ACTIVE';
        }
        if ($this->smart_saving_events == 0) {
            return 'INACTIVE';
        }
    }
    
    public function getImgURL() {
        if ($this->img != null) {
            return Yii::$app->params['back_host'] . 'packages/' . $this->img;
        } else {
            return Yii::$app->params['back_host'] . 'default.jpg';
        }
    }
}
