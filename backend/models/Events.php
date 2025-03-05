<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $address
 * @property string $date_time
 * @property string $registration_deadline
 * @property int $maximum_participations
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Activity[] $activities
 * @property Profiles[] $profiles
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'address', 'date_time', 'registration_deadline', 'maximum_participations', 'status', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['date_time', 'registration_deadline'], 'safe'],
            [['maximum_participations', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
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
            'address' => 'Address',
            'date_time' => 'Date Time',
            'registration_deadline' => 'Registration Deadline',
            'maximum_participations' => 'Maximum Participations',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Activities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::class, ['event_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::class, ['id' => 'profile_id'])->viaTable('activity', ['event_id' => 'id']);
    }
}
