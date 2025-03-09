<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 * 
 * @property Role $role
 * @property AuthAssignment $authAssignment
 * @property Merchant[] $merchants
 * @property Profile[] $profiles
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const SCENARIO_PASSWORD_CHANGE = 'passwordChange';

    public $password;
    public $newpassword;

    public static function tableName() {
        return '{{%users}}';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PASSWORD_CHANGE] = ['oldpassword', 'newpassword'];
        return $scenarios;
    }

    public function rules() {
        return [
            [['email', 'status'], 'required'],
            [['email', 'status', 'password', 'newpassword'], 'safe'],
            [['email'], 'unique'],
            [['email'], 'email'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            
            [['password', 'newpassword'], 'required', 'on' => self::SCENARIO_PASSWORD_CHANGE],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Email',
            'newpassword' => 'New Password',
            'password' => 'Password',
            'status' => 'Status',
            'statusText' => 'Status',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email) {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                    'verification_token' => $token,
                    'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function getDepartment() {
        return $this->hasOne(Departments::class, ['id' => 'department_id']);
    }

    public function getRequests() {
        return $this->hasMany(Request::class, ['user_id' => 'id']);
    }

    public function getauth_assignment() {
        return $this->hasOne(AuthAssignment::class, ['user_id' => 'id']);
    }

    public function getStatusText() {
        if ($this->status == self::STATUS_ACTIVE) {
            return 'ACTIVE';
        }
        if ($this->status == self::STATUS_INACTIVE) {
            return 'INACTIVE';
        }
        if ($this->status == self::STATUS_DELETED) {
            return 'DELETED';
        }
    }

    public function getRole() {
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRolesByUser($this->id);
        $roleArray = [];
        if (count($roles) > 0) {
            foreach ($roles as $roleName => $role) {
                $roleArray[] = $roleName;
            }
            return $roleArray[0];
        } else {
            return null;
        }
    }

    public function getMerchants() {
        return $this->hasMany(Merchant::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles() {
        return $this->hasMany(Profile::class, ['user_id' => 'id']);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }
}
