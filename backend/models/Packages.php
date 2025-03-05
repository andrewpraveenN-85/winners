<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "packages".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $duration
 * @property int $entry_point
 * @property int $smart_saving_events
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
class Packages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'packages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'duration', 'smart_saving_events', 'status', 'created_at', 'updated_at'], 'required'],
            [['description', 'duration'], 'string'],
            [['entry_point', 'smart_saving_events', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'duration' => 'Duration',
            'entry_point' => 'Entry Point',
            'smart_saving_events' => 'Smart Saving Events',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Draws]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDraws()
    {
        return $this->hasMany(Draws::class, ['package_id' => 'id']);
    }

    /**
     * Gets query for [[Memberships]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMemberships()
    {
        return $this->hasMany(Memberships::class, ['package_id' => 'id']);
    }

    /**
     * Gets query for [[Merchants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMerchants()
    {
        return $this->hasMany(Merchants::class, ['id' => 'merchant_id'])->viaTable('offers', ['package_id' => 'id']);
    }

    /**
     * Gets query for [[Offers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOffers()
    {
        return $this->hasMany(Offers::class, ['package_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::class, ['id' => 'profile_id'])->viaTable('memberships', ['package_id' => 'id']);
    }
}
