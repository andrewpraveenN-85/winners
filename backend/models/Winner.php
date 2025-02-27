<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "winner".
 *
 * @property int $profile_id
 * @property int $draws_gifts_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DrawsGifts $drawsGifts
 * @property Profile $profile
 */
class Winner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'winner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'draws_gifts_id', 'status', 'created_at', 'updated_at'], 'required'],
            [['profile_id', 'draws_gifts_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['profile_id', 'draws_gifts_id'], 'unique', 'targetAttribute' => ['profile_id', 'draws_gifts_id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],
            [['draws_gifts_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrawsGifts::class, 'targetAttribute' => ['draws_gifts_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'draws_gifts_id' => 'Draws Gifts ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[DrawsGifts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrawsGifts()
    {
        return $this->hasOne(DrawsGifts::class, ['id' => 'draws_gifts_id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }
}
