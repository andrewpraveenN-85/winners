<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gifts".
 *
 * @property int $id
 * @property int $draw_id
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Draws $draw
 * @property Profiles[] $profiles
 * @property Winners[] $winners
 */
class Gifts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gifts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['draw_id', 'name', 'status', 'created_at', 'updated_at'], 'required'],
            [['draw_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['draw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Draws::class, 'targetAttribute' => ['draw_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'draw_id' => 'Draw ID',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Draw]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDraw()
    {
        return $this->hasOne(Draws::class, ['id' => 'draw_id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::class, ['id' => 'profile_id'])->viaTable('winners', ['gift_id' => 'id']);
    }

    /**
     * Gets query for [[Winners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWinners()
    {
        return $this->hasMany(Winners::class, ['gift_id' => 'id']);
    }
}
