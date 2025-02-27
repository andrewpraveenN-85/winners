<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $sin
 * @property string $email
 * @property string $mobile
 * @property string|null $dob
 * @property string $gender
 * @property string $proffetion
 * @property string|null $address
 * @property string $location
 * @property string $membership
 * @property int $draw_eligible_count
 * @property string $shopping_preferences_Behavior
 * @property string $favorite_categories
 * @property int $reward_participation
 * @property string $profile_img
 * @property string $qr_img
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Winner[] $winners
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name', 'middle_name', 'last_name', 'sin', 'email', 'mobile', 'gender', 'proffetion', 'location', 'membership', 'shopping_preferences_Behavior', 'favorite_categories', 'reward_participation', 'profile_img', 'qr_img', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'draw_eligible_count', 'reward_participation', 'created_at', 'updated_at'], 'integer'],
            [['dob'], 'safe'],
            [['shopping_preferences_Behavior', 'favorite_categories'], 'string'],
            [['first_name', 'middle_name', 'last_name', 'email', 'proffetion', 'address', 'location', 'membership', 'profile_img', 'qr_img'], 'string', 'max' => 255],
            [['sin', 'mobile'], 'string', 'max' => 15],
            [['gender'], 'string', 'max' => 5],
            [['email'], 'unique'],
            [['sin'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'email' => 'Email',
            'mobile' => 'Mobile',
            'dob' => 'Dob',
            'gender' => 'Gender',
            'proffetion' => 'Proffetion',
            'address' => 'Address',
            'location' => 'Location',
            'membership' => 'Membership',
            'draw_eligible_count' => 'Draw Eligible Count',
            'shopping_preferences_Behavior' => 'Shopping Preferences Behavior',
            'favorite_categories' => 'Favorite Categories',
            'reward_participation' => 'Reward Participation',
            'profile_img' => 'Profile Img',
            'qr_img' => 'Qr Img',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Winners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWinners()
    {
        return $this->hasMany(Winner::class, ['profile_id' => 'id']);
    }
}
