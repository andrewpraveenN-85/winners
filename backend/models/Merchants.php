<?php

namespace backend\models;

use Yii;
use backend\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "merchants".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $bussiness_name
 * @property string $last_name
 * @property string $brn
 * @property string|null $mobile
 * @property string|null $dor
 * @property string|null $type
 * @property string|null $address
 * @property string|null $notes
 * @property string|null $img
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Offers[] $offers
 * @property Packages[] $packages
 * @property User $user
 */
class Merchants extends \yii\db\ActiveRecord {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public $image;
    public $email;
    public $status;

    public static function tableName() {
        return 'merchants';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules() {
        return [
            [['first_name', 'bussiness_name', 'last_name', 'brn', 'email', 'status'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['user_id', 'dor', 'type', 'address', 'img', 'email', 'status', 'img'], 'safe'],
            [['notes'], 'string'],
            [['first_name', 'bussiness_name', 'last_name', 'type', 'address', 'img'], 'string', 'max' => 255],
            [['brn', 'mobile'], 'string', 'max' => 15],
            [['brn'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['email'], 'email'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels() {
        return [
            'user_id' => 'User',
            'first_name' => 'First Name',
            'bussiness_name' => 'Bussiness Name',
            'last_name' => 'Last Name',
            'brn' => 'Business Reg No',
            'mobile' => 'Mobile',
            'dor' => 'Date of Reg',
            'type' => 'Type',
            'address' => 'Address',
            'notes' => 'Note',
            'img' => 'Logo',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    public function getOffers() {
        return $this->hasMany(Offers::class, ['merchant_id' => 'id']);
    }

    public function getPackages() {
        return $this->hasMany(Packages::class, ['id' => 'package_id'])->viaTable('offers', ['merchant_id' => 'id']);
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function createUser() {
        $user = new User();
        $user->email = $this->email;
        $user->status = $this->status;
        if ($user->save()) {
            return $user->id;
        }
        return false;
    }

    public function getImgURL() {
        if ($this->img != null) {
            return Yii::$app->params['back_host'] . 'merchant/' . $this->img;
        } else {
            return Yii::$app->params['back_host'] . 'default.jpg';
        }
    }
}
