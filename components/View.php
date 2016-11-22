<?php
/**
 * 
 * @author Julio Vedovatto <juliovedovatto@gmail.com>
 *
 */

namespace app\components;

use Yii;

class View extends \yii\web\View {
	
	public $title = [];
	
	public function init() {
		$this->addTitle(Yii::$app->params['title']);
	}
	
	
	public function getTitle() {
		return is_array($this->title) ? implode(' - ', $this->title) : $this->title;
	}
	
	public function setTitle($title) {
		if (!is_array($title))
			$title = [$title];
	
			$this->title = $title;
				
			return $this;
	}
	
	public function addTitle($title) {
		array_unshift($this->title, $title);
	
		return  $this;
	}
	
	public function getSuccessFlash() {
		return Yii::$app->getSession()->getFlash('success');
	}
	
	
	public function getErrorFlash() {
		return Yii::$app->getSession()->getFlash('error');
	}
	
	
	public function getLoggedUser() {
		return Yii::$app->getUser()->getIdentity() ?: null;
	}
	
	public function isUserLoggedIn() {
		return $this->getLoggedUser() ? true : false;
	}
	
	/**
	 * Check if the logged user is Admin
	 * @return boolean
	 */
	public function isLoggedUserAdmin() {
		$user = Yii::$app->getUser()->getIdentity() ?: null;
		
		return $user && $user->isAdmin();
	}
	
}