<?php

namespace backend\models;

use Yii;

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
class Memberships extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'memberships';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'package_id', 'status', 'created_at', 'updated_at'], 'required'],
            [['profile_id', 'package_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['profile_id', 'package_id'], 'unique', 'targetAttribute' => ['profile_id', 'package_id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::class, 'targetAttribute' => ['package_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'package_id' => 'Package ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Package]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Packages::class, ['id' => 'package_id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::class, ['id' => 'profile_id']);
    }
}
