<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "draws_gifts".
 *
 * @property int $id
 * @property int $draws_id
 * @property string $gift_name
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Draws $draws
 * @property DrawsGiftsRewards[] $drawsGiftsRewards
 * @property Winner[] $winners
 */
class DrawsGifts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'draws_gifts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['draws_id', 'gift_name', 'status', 'created_at', 'updated_at'], 'required'],
            [['draws_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['gift_name'], 'string', 'max' => 255],
            [['draws_id'], 'exist', 'skipOnError' => true, 'targetClass' => Draws::class, 'targetAttribute' => ['draws_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'draws_id' => 'Draws ID',
            'gift_name' => 'Gift Name',
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
        return $this->hasOne(Draws::class, ['id' => 'draws_id']);
    }

    /**
     * Gets query for [[DrawsGiftsRewards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrawsGiftsRewards()
    {
        return $this->hasMany(DrawsGiftsRewards::class, ['draws_gift_id' => 'id']);
    }

    /**
     * Gets query for [[Winners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWinners()
    {
        return $this->hasMany(Winner::class, ['draws_gifts_id' => 'id']);
    }
}
