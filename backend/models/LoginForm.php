<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model {

    public $email;
    public $password;
    public $rememberMe = true;
    private $_user;

    public function rules() {
        return [
            // username and password are both required
            [['email', 'email'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
