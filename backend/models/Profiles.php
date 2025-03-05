<?php

namespace backend\models;

use Yii;

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
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name', 'last_name', 'sin', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['dob'], 'safe'],
            [['notes'], 'string'],
            [['first_name', 'middle_name', 'last_name', 'address', 'img'], 'string', 'max' => 255],
            [['sin', 'mobile'], 'string', 'max' => 15],
            [['gender'], 'string', 'max' => 5],
            [['sin'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'sin' => 'Sin',
            'mobile' => 'Mobile',
            'dob' => 'Dob',
            'gender' => 'Gender',
            'address' => 'Address',
            'notes' => 'Notes',
            'img' => 'Img',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Activities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::class, ['id' => 'event_id'])->viaTable('activity', ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Gifts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGifts()
    {
        return $this->hasMany(Gifts::class, ['id' => 'gift_id'])->viaTable('winners', ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Memberships]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMemberships()
    {
        return $this->hasMany(Memberships::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Packages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPackages()
    {
        return $this->hasMany(Packages::class, ['id' => 'package_id'])->viaTable('memberships', ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Winners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWinners()
    {
        return $this->hasMany(Winners::class, ['profile_id' => 'id']);
    }
}
