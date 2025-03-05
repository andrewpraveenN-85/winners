<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "draws".
 *
 * @property int $id
 * @property int $package_id
 * @property string $date_time
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Gifts[] $gifts
 * @property Packages $package
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
            [['package_id', 'date_time', 'status', 'created_at', 'updated_at'], 'required'],
            [['package_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['date_time'], 'safe'],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::class, 'targetAttribute' => ['package_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_id' => 'Package ID',
            'date_time' => 'Date Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Gifts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGifts()
    {
        return $this->hasMany(Gifts::class, ['draw_id' => 'id']);
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
}
