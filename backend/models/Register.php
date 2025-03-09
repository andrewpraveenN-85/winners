<?php

namespace backend\models;

use Yii;
use backend\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $sin
 * @property string|null $mobile
 * @property string|null $dob
 * @property string|null $gender
 * @property string|null $dor
 * @property string|null $address
 * @property string|null $notes
 * @property string|null $img
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Activity[] $activities
 * @property Events[] $events
 * @property Gifts[] $gifts
 * @property Memberships[] $memberships
 * @property Packages[] $packages
 * @property Users $user
 * @property Winners[] $winners
 */
class Register extends \yii\db\ActiveRecord {

    public $image;
    public $email;
    public $password;
    public $status;
    public $accept_age;
    public $accept_terms;

    public static function tableName() {
        return 'profiles';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules() {
        return [
            [['user_id', 'first_name', 'last_name', 'sin', 'email', 'dob', 'address', 'mobile', 'gender', 'password'], 'required'],
            [[ 'created_at', 'updated_at'], 'integer'],
            [['user_id', 'dob', 'dor', 'address', 'img', 'notes', 'email', 'status', 'image'], 'safe'],
            [['notes'], 'string'],
            [['first_name', 'middle_name', 'last_name', 'address', 'img'], 'string', 'max' => 255],
            [['sin', 'mobile', 'gender'], 'string', 'max' => 15],
            [['dor'], 'string', 'max' => 15],
            [['sin'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['email'], 'email'],
            [['accept_terms'], 'required', 'requiredValue' => 1, 'message' => 'You must accept the terms.'],
            [['accept_terms'], 'boolean'], // Ensure it's a boolean value
            [['accept_age'], 'required', 'requiredValue' => 1, 'message' => 'You must accept the age restrictions.'],
            [['accept_age'], 'boolean'], // Ensure it's a boolean value
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'sin' => 'NIC/Driving Licence/Passport No',
            'mobile' => 'Mobile',
            'dob' => 'Date of Birth',
            'gender' => 'Gender',
            'dor' => 'Date or Register',
            'address' => 'Address',
            'notes' => 'Notes',
            'img' => 'Picture',
            'accept_terms' => 'I agree to Competition terms and conditions',
            'accept_age' => 'I agree that I\'m over the age 18'
        ];
    }

    public function getActivities() {
        return $this->hasMany(Activity::class, ['profile_id' => 'id']);
    }

    public function getEvents() {
        return $this->hasMany(Events::class, ['id' => 'event_id'])->viaTable('activity', ['profile_id' => 'id']);
    }

    public function getGifts() {
        return $this->hasMany(Gifts::class, ['id' => 'gift_id'])->viaTable('winners', ['profile_id' => 'id']);
    }

    public function getMemberships() {
        return $this->hasMany(Memberships::class, ['profile_id' => 'id']);
    }

    public function getPackages() {
        return $this->hasMany(Packages::class, ['id' => 'package_id'])->viaTable('memberships', ['profile_id' => 'id']);
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getWinners() {
        return $this->hasMany(Winners::class, ['profile_id' => 'id']);
    }

    public function createUser() {
        $user = new User();
        $user->email = $this->email;
        $user->status = $this->status;
        $user->password = $this->password;
        if ($user->save(false)) {
            return $user->id;
        }
        return false;
    }

    public function getImgURL() {
        if ($this->img != null) {
            return Yii::$app->params['back_host'] . 'profile/' . $this->img;
        } else {
            return Yii::$app->params['back_host'] . 'default.jpg';
        }
    }
}
