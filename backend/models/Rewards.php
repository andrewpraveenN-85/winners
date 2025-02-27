<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rewards".
 *
 * @property int $id
 * @property int $merchant_id
 * @property string $reward_name
 * @property string $reward_details
 * @property string $start_date
 * @property string $end_date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DrawsGiftsRewards[] $drawsGiftsRewards
 * @property Merchant $merchant
 */
class Rewards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rewards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'reward_name', 'reward_details', 'start_date', 'end_date', 'status', 'created_at', 'updated_at'], 'required'],
            [['merchant_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['reward_details'], 'string'],
            [['start_date', 'end_date'], 'safe'],
            [['reward_name'], 'string', 'max' => 255],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Merchant::class, 'targetAttribute' => ['merchant_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'merchant_id' => 'Merchant ID',
            'reward_name' => 'Reward Name',
            'reward_details' => 'Reward Details',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[DrawsGiftsRewards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrawsGiftsRewards()
    {
        return $this->hasMany(DrawsGiftsRewards::class, ['rewards_id' => 'id']);
    }

    /**
     * Gets query for [[Merchant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMerchant()
    {
        return $this->hasOne(Merchant::class, ['id' => 'merchant_id']);
    }
}
