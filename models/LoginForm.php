<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 * 
 * @author Julio Vedovatto <juliovedovatto@gmail.com>
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username,
    	$password,
    	$rememberMe = true;
    

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
        	[['username'], 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }
    
    public function attributeLabels()
    {
    	return [
			'username' => 'Email',
			'password' => 'Password',
    	];
    }
    
//	CUSTOM METHODS --------------------------------------------------------------------------------------------------------------    

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($password, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password))
                $this->addError($password, 'Incorrect username or password.');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate())
            return Yii::$app->getUser()->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        
        return false;
    }

    /**
     * Finds user by Email
     * @return User|null
     */
    public function getUser()
    {
        if (!$this->_user)
            $this->_user = User::findByEmail($this->username);

        return $this->_user;
    }
}
