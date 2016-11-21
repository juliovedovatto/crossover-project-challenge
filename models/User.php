<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property integer $type
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Article[] $articles
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	
	const TYPE_ADMIN = 1,
		TYPE_USER = 0,
		STATUS_NEEDS_VALIDATION = 0,
		STATUS_ENABLED = 1,
		STATUS_DISABLED = 2;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['name', 'email', 'password'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
			[['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id_user' => 'id']);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
    	return self::findOne(array('id' => $id)) ?: null;
    }
    
//	CUSTOM METHODS --------------------------------------------------------------------------------------------------------------    
   
    /**
     * Finds user by email
     *
     * @param string $email
     * @return User|null
     */
    public static function findByEmail($email)
    {
    	return self::findOne(array('email' => $email)) ?: null;
    }
    
    public static function hashPassword($password) {
    	return Yii::$app->getSecurity()->generatePasswordHash($password);
    }
    	
    public static function generateRandomPassword() {
    	return Yii::$app->getSecurity()->generateRandomString(8);
    }
    
    /**
     * Method to check if the loaded user is a admin user.
     * @return boolean
     */
    public function isAdmin() {
    	if (!$this->id)
    		return false;
    	
    	return $this->type == $this::TYPE_ADMIN;
    }
    
    /**
     * Method to check if the loaded user is a normal user.
     * @return boolean
     */
    public function isUser() {
    	if (!$this->id)
    		return false;
    	
    	return $this->type == $this::TYPE_ADMIN;
    }
    
//	/CUSTOM METHODS -------------------------------------------------------------------------------------------------------------    
    
//	REQUIRED METHODS (BY IdentityInterface) -------------------------------------------------------------------------------------    
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
    	return $this->id;
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
    	return '';
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
    	return $this->authKey === $authKey;
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	return null;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
    	if (!$this->id)
    		return false;
    
    	return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    
//	/REQUIRED METHODS (BY IdentityInterface) ------------------------------------------------------------------------------------    
}