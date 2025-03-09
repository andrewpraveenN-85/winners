<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\User;

class ChangePasswordForm extends Model {
    public $password;
    public $newpassword;
    
    private $_user;

    public function __construct($userId, $config = []) {
        $this->_user = User::findOne($userId);
        if (!$this->_user) {
            throw new \yii\web\NotFoundHttpException('User not found');
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['password', 'newpassword'], 'required'],
            ['password', 'validateCurrentPassword'],
            ['newpassword', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels() {
        return [
            'password' => 'Current Password',
            'newpassword' => 'New Password',
        ];
    }

    public function validateCurrentPassword($attribute, $params) {
        if (!$this->_user || !Yii::$app->security->validatePassword($this->$attribute, $this->_user->password_hash)) {
            $this->addError($attribute, 'Incorrect current password.');
        }
    }

    public function changePassword() {
        if ($this->validate()) {
            $this->_user->setPassword($this->newpassword);
            $this->_user->save(false);
            return true;
        }
        return false;
    }
}
