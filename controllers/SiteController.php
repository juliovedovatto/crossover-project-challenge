<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\HttpException;
use app\models\LoginForm;
use app\models\Article;
use app\components\Helper;
use kartik\mpdf\Pdf;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;


class SiteController extends \app\components\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'register', 'articles', 'index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            	'testLimit' => 1,
            ],
        ];
    }
    
    public function beforeAction($action) {
    	$whitelist = ['change-password', 'logout'];
    	
    	/* @var $user \app\models\User */
    	if (($user = $this->getUser()) && $user->status == $user::STATUS_NEEDS_VALIDATION && !in_array($action->id, $whitelist))
    		return $this->redirect('/change-password');
    	
    	return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    	$articles = Article::find()
    		->where('status = :status', [ 'status' => Article::STATUS_ENABLED ])
    		->orderBy('published_at DESC')
    		->limit(10)
    		->all();
    	
        return $this->render('index', [ 'articles' => $articles ?: [] ]);
    }

// 	USER ------------------------------------------------------------------------------------------------------------------------
    
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
        	$user = $model->getUser();
        	
        	if ($user->status == $user::STATUS_NEEDS_VALIDATION)
        		return $this->redirect('/change-password');
        	
        	return $this->redirect(!empty(Yii::$app->getRequest()->referrer) ? Yii::$app->getRequest()->referrer : '/');;
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

    /**
     * @return string
     */
    public function actionRegister()
    {
        $model = new \app\models\User();
        
        if ($data = Yii::$app->request->post()) {
        	
        	$temporary_password = $model->generateRandomPassword();
        	
        	$user = $data['User'];
        	
        	$model->name = $user['name'];
        	$model->type = $model::TYPE_USER;
        	$model->status = $model::STATUS_NEEDS_VALIDATION;
        	$model->email = $user['email'];
        	$model->password = $model->hashPassword($temporary_password);
        	$model->created_at = new \yii\db\Expression('NOW()');
        	
        	if ($model->validate() && $model->save()) {
        		
        		$mail = $this->sendMail($model->email, 'News Portal: Registration Password', $this->renderPartial('/mail/register', array('user' => $model, 'password' => $temporary_password)));
        		if ($mail)
	        		$this->addSuccessMessage('Registration successful. You will receive an email (' . $model->email . ') with your temporary password soon :)');
        		else
        			$this->addSuccessMessage('Registration successful. Unfurtunatelly, we had a error emailing you. Your new password is <strong>' . $temporary_password . '</strong>');
        		
        		return $this->redirect('/login');
        	}
        	
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }
    
    public function actionChangePassword() {
    	if (!$user = $this->getUser())
    		throw new HttpException(403, 'User not authorized');
    	
    	$user->password = '';
    	if ($data = Yii::$app->getRequest()->post()) {
    		$user_data = $data['User'];
    		
    		$user->password = $user->hashPassword($user_data['password']);
    		$user->status = $user::STATUS_ENABLED;
    		
    		if ($user->save()) 
    			return $this->redirect('/');
    		else {
    			$user->password = '';
    			$this->addErrorMessage('Unknown error while saving the new password.');
    		}
    	}
    	
    	return $this->render('login-password', array('model' => $user));
    }
    
//	/USER -----------------------------------------------------------------------------------------------------------------------
    
//	ARTICLES -------------------------------------------------------------------------------------------------------------------- 
    
    public function actionArticles() {
    	$stmt = Article::find();
    	
    	if (!$this->getUser() || !$this->getUser()->isAdmin())
    		$stmt->where('status = :status', [ 'status' => Article::STATUS_ENABLED ])->orderBy('published_at DESC');
    	else if ($this->getUser() && $this->getUser()->isAdmin())
    		$stmt->orderBy('id DESC');
    	
	    $articles = $stmt->all();
	    
    	return $this->render('articles', array('articles' => $articles));
    }
    
    public function actionArticle($id) {
    	if (!$article = Article::findOne(array('id' => $id)))
    		throw new HttpException(404, 'Article not found');
    	elseif ($article->status != $article::STATUS_ENABLED && (!$this->isLoggedUserAdmin()) && ($article->id_user != $this->getUser()->id))
    		throw new HttpException(404);
    	
    	return $this->render('article', array('article' => $article));
    }
    
    public function actionSubmitArticle() {
    	$model = new Article();
    	
    	
    	if ($data = Yii::$app->getRequest()->post()) {
    		 
    		$article = $data['Article'];
    		 
    		$model->title = $article['title'];
    		$model->text = \yii\helpers\HtmlPurifier::process($article['text']);
    		$model->excerpt = strip_tags($article['excerpt']);
    		$model->picture = UploadedFile::getInstance($model, 'picture');
    		$model->id_user = $this->getUser()->id;
    		
    		$model->created_at = new \yii\db\Expression('NOW()');
    		$model->status = $model::STATUS_MODERATION;
    		
    		if ($this->getUser() && $this->getUser()->isAdmin()) {
    			$model->status = $model::STATUS_ENABLED;
    			$model->published_at = new \yii\db\Expression('NOW()');
    		}
    		 
    		$transaction = Yii::$app->getDb()->beginTransaction();
    		
    		if ($model->validate() && $model->save()) {
    			
    			$filename = 'article-' . str_pad($model->id, 21, '0', STR_PAD_LEFT) . '.' . strtolower($model->picture->extension);
    			$filepath = Yii::getAlias('@app') . '/web/media/articles/' . floor($model->id / 1000) . '/' . $filename;
    			
    			if (!is_dir(dirname($filepath)) && !mkdir(dirname($filepath), 0775, true))
    				throw new \Exception('Error saving article picture (error creating directory).');
    			elseif (!$model->picture->saveAs($filepath, false))
    				throw new \Exception('Error saving article picture.');
    			
    			$model->picture = str_replace(Yii::getAlias('@app') . '/web/', '', $filepath);
    			
    			if ($model->save(false)) { // validation needs to be turned off to save picture file path correctly
	    			$transaction->commit();
	    			$this->addSuccessMessage('Article subbmited with success.');
	    			$model = new Article();
    			}
    		}
    		 
    	}
    	
    	return $this->render('article-submit', ['model' => $model]);
    }
    
    public function actionArticleAdmin($action, $id) {
    	if (!$this->isLoggedUserAdmin())
    		throw new HttpException(403, 'Invalid Action');
    	elseif (!$article = Article::findOne(array('id' => $id)))
    		throw new HttpException(404, 'Article not found');
    	
    	switch ($action) {
    		case 'approve':
    			$article->status = $article::STATUS_ENABLED;
    			$article->published_at = new \yii\db\Expression('NOW()');
    			
    			if (!$article->save(false))
    				throw new \Exception('Error publishing article');
    			
				$this->addSuccessMessage('Article successfully approved.');
    			return $this->redirect('/article/' . $article->id);
    		case 'disable':
    			
    			$article->status = $article::STATUS_DISABLED;
    			$article->published_at = null;
    			if (!$article->save(false))
    				throw new \Exception('Error disabling article');
    			
				$this->addSuccessMessage('Article successfully disabled.');
				return $this->redirect('/article/' . $article->id);
    		case 'delete':
    			if (!$article->delete())
    				throw new \Exception('Error publishing article');
    				
    			$picture = Yii::getAlias('@app') . '/web/' . $article->picture;
    			if (is_file($picture))
	    			unlink($picture);
    			
    			$this->addSuccessMessage('Article successfully deleted.');
    			return $this->redirect('/articles');
    		default:
    			throw new HttpException(500, 'Invalid Action for the article');
    	}
    }
    
    public function actionArticleDownload($id) {
    	if (!$article = Article::findOne(array('id' => $id)))
    		throw new HttpException(404, 'Article not found');
		elseif ($article->status != $article::STATUS_ENABLED && (!$this->isLoggedUserAdmin()))
    		throw new HttpException(404);
		
    		$pdf = new Pdf([
				'mode' => Pdf::MODE_CORE,
				'format' => Pdf::FORMAT_A4,
    			'filename' => 'newsportal-article-' . $article->id . '.pdf',
				'orientation' => Pdf::ORIENT_PORTRAIT,
				'destination' => Pdf::DEST_DOWNLOAD,
				'content' => $this->renderPartial('article-pdf', array('article' => $article)),
				'options' => ['title' => $article->title . ' - News Portal'],
				'methods' => [
					'SetHeader'=>['Article - News Portal'],
					'SetFooter'=>['Newsportal ' . date('Y') . ' / Page: {PAGENO}'],
				]
    		]);
    		
    		return $pdf->render();
    }
    
    public function actionMyArticles() {
    	if (!$this->getUser())
    		throw new HttpException(403, 'Invalid action');
    	
    	$articles = Article::find()
    		->where(array('id_user' => $this->getUser()->id))
	    	->orderBy('id DESC')
	    	->limit(10)
	    	->all();
    	
	    return $this->render('articles', array('my' => true, 'articles' => $articles));
    }
    
    
    public function actionRss() {
    	$app = Yii::$app;
    	
		$dataProvider = new ActiveDataProvider([
	        'query' => $articles = Article::find()
				->with('user')
	    		->where('status = :status', [ 'status' => Article::STATUS_ENABLED ])
	    		->orderBy('published_at DESC'),
	        'pagination' => [
	            'pageSize' => 10
	        ],
	    ]);
		
	    $response = Yii::$app->getResponse();
	    $headers = $response->getHeaders();
	    
	    $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');
    	
    	echo \Zelenin\yii\extensions\Rss\RssView::widget([
			'dataProvider' => $dataProvider,
			'channel' => [
				'title' => function ($widget, $feed) {
					$feed->addChannelTitle('RSS Feed - News Portal');
				},
				'link' => Url::toRoute('/', true),
				'description' => 'Latest articles from News Portal',
				'language' => function ($widget, $feed) {
					return Yii::$app->language;
				}
			],
			'items' => [
				'title' => function ($article, $widget, $feed) {
					return $article->title;
				},
				'description' => function ($article, $widget, $feed) {
					return strlen(trim($article->excerpt)) ? $article->excerpt : Helper::str_truncate($article->text, 50);
				},
				'link' => function ($article, $widget, $feed) {
					return Url::toRoute('/article/' . $article->id, true);
				},
				'author' => function ($article, $widget, $feed) {
					return $article->user->email . ' (' . $article->user->name . ')';
				},
				'guid' => function ($article, $widget, $feed) {
					$date = \DateTime::createFromFormat('Y-m-d H:i:s', $article->updated_at);
					return Url::toRoute('/article/' . $article->id, true) . ' ' . $date->format(DATE_RSS);
				},
				'pubDate' => function ($article, $widget, $feed) {
					$date = \DateTime::createFromFormat('Y-m-d H:i:s', $article->published_at);
					return $date->format(DATE_RSS);
				}
			],
		]);

    	return $app->end($app::STATE_END);
    }
    
//	/ARTICLES ------------------------------------------------------------------------------------------------------------------- 

}
