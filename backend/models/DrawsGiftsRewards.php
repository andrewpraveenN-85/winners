<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "draws_gifts_rewards".
 *
 * @property int $draws_gift_id
 * @property int $rewards_id
 *
 * @property DrawsGifts $drawsGift
 * @property Rewards $rewards
 */
class DrawsGiftsRewards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'draws_gifts_rewards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['draws_gift_id', 'rewards_id'], 'required'],
            [['draws_gift_id', 'rewards_id'], 'integer'],
            [['draws_gift_id', 'rewards_id'], 'unique', 'targetAttribute' => ['draws_gift_id', 'rewards_id']],
            [['draws_gift_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrawsGifts::class, 'targetAttribute' => ['draws_gift_id' => 'id']],
            [['rewards_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rewards::class, 'targetAttribute' => ['rewards_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'draws_gift_id' => 'Draws Gift ID',
            'rewards_id' => 'Rewards ID',
        ];
    }

    /**
     * Gets query for [[DrawsGift]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrawsGift()
    {
        return $this->hasOne(DrawsGifts::class, ['id' => 'draws_gift_id']);
    }

    /**
     * Gets query for [[Rewards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRewards()
    {
        return $this->hasOne(Rewards::class, ['id' => 'rewards_id']);
    }
}
