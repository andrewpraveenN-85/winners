<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "draws".
 *
 * @property int $id
 * @property string $date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DrawsGifts[] $drawsGifts
 */
class Draws extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'draws';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'status', 'created_at', 'updated_at'], 'required'],
            [['date'], 'safe'],
            [['status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
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
        return $this->hasMany(DrawsGifts::class, ['draws_id' => 'id']);
    }
}
