<?php
/**
 * @author Julio Vedovatto <juliovedovatto@gmail.com>
 */

namespace app\components;

use Yii;

class Controller extends \yii\web\Controller {
	
	public function __construct($id, $module, $config = [])
	{
		parent::__construct($id, $module, $config);
	}

	/**
	 * Method for sending email
	 * @param string $to
	 * @param string $subject
	 * @param string $message
	 * 
	 * @return boolean
	 */
	public function sendMail($to, $subject, $message) {
		$config = Yii::$app->getComponents(true);
		
		return Yii::$app->getMailer()->compose()
			->setFrom([$config['mailer']['config']['username'] => 'News Portal'])
			->setTo($to)
			->setSubject($subject)
			->setTextBody($message)
			->send();
	}
	
	/**
	 * @return User|null
	 */
	public function getUser() {
		return Yii::$app->getUser()->getIdentity() ?: null;
	}
	
	/**
	 * Check if the logged user is admin.
	 * @return boolean
	 */
	public function isLoggedUserAdmin() {
		if (!$user = $this->getUser())
			return false;
		
		return $user->isAdmin();
	}
	
	/**
	 * Method to add a successfully flash message.
	 * @param string $message
	 * @return \app\components\Controller
	 */
	public function addSuccessMessage($message) {
		Yii::$app->getSession()->setFlash('success', $message);
		
		return $this;
	}
	
	/**
	 * Method to add an error flash message.
	 * @param string $message
	 * @return \app\components\Controller
	 */
	public function addErrorMessage($message) {
		Yii::$app->getSession()->setFlash('error', $message);
		
		return $this;
	}
}