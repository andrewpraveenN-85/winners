<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "winners".
 *
 * @property int $profile_id
 * @property int $gift_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Gifts $gift
 * @property Profiles $profile
 */
class Winners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'winners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'gift_id', 'status', 'created_at', 'updated_at'], 'required'],
            [['profile_id', 'gift_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['profile_id', 'gift_id'], 'unique', 'targetAttribute' => ['profile_id', 'gift_id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
            [['gift_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gifts::class, 'targetAttribute' => ['gift_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'gift_id' => 'Gift ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Gift]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGift()
    {
        return $this->hasOne(Gifts::class, ['id' => 'gift_id']);
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
