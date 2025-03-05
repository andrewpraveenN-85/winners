<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property int $profile_id
 * @property int $event_id
 * @property string $check_in
 * @property string $check_out
 * @property string $notes
 *
 * @property Events $event
 * @property Profiles $profile
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'event_id', 'check_in', 'check_out', 'notes'], 'required'],
            [['profile_id', 'event_id'], 'integer'],
            [['check_in', 'check_out'], 'safe'],
            [['notes'], 'string'],
            [['profile_id', 'event_id'], 'unique', 'targetAttribute' => ['profile_id', 'event_id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::class, 'targetAttribute' => ['event_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'event_id' => 'Event ID',
            'check_in' => 'Check In',
            'check_out' => 'Check Out',
            'notes' => 'Notes',
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::class, ['id' => 'event_id']);
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
