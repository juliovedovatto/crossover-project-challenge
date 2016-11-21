<?php

namespace app\models;

use Yii;
use app\components\Helper;
use yii\helpers\Url;

/**
 * This is the model class for table "article".
 *
 * @property string $id
 * @property string $id_user
 * @property string $title
 * @property string $text
 * @property string $excerpt
 * @property string $picture
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 *
 * @property User $idUser
 */
class Article extends \yii\db\ActiveRecord
{
	
	const STATUS_ENABLED = 2,
		STATUS_DISABLED = 0,
		STATUS_MODERATION = 1;
	
		
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'title', 'text', 'picture'], 'required'],
            [['id_user', 'status'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at', 'published_at'], 'safe'],
            [['title', 'excerpt'], 'string', 'max' => 255],
        	[['picture'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'title' => 'Title',
            'text' => 'Text',
            'excerpt' => 'Excerpt',
            'picture' => 'Picture',
            'status' => 'Status',
        	'captcha' => 'Verify Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'published_at' => 'Published At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
    
}
