<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "merchant".
 *
 * @property int $id
 * @property int $user_id
 * @property string $bussiness_name
 * @property string $address
 * @property string $location
 * @property string $owner_name
 * @property string $owner_contact_no
 * @property string $manager_name
 * @property string $manager_contact_no
 * @property string $business_category
 * @property string $bussiness_logo
 * @property string $qr_img
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Rewards[] $rewards
 * @property User $user
 */
class Merchant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merchant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'bussiness_name', 'address', 'location', 'owner_name', 'owner_contact_no', 'manager_name', 'manager_contact_no', 'business_category', 'bussiness_logo', 'qr_img', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['bussiness_name', 'address', 'location', 'owner_name', 'manager_name', 'business_category', 'bussiness_logo', 'qr_img'], 'string', 'max' => 255],
            [['owner_contact_no', 'manager_contact_no'], 'string', 'max' => 15],
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
            'bussiness_name' => 'Bussiness Name',
            'address' => 'Address',
            'location' => 'Location',
            'owner_name' => 'Owner Name',
            'owner_contact_no' => 'Owner Contact No',
            'manager_name' => 'Manager Name',
            'manager_contact_no' => 'Manager Contact No',
            'business_category' => 'Business Category',
            'bussiness_logo' => 'Bussiness Logo',
            'qr_img' => 'Qr Img',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Rewards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRewards()
    {
        return $this->hasMany(Rewards::class, ['merchant_id' => 'id']);
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
}
