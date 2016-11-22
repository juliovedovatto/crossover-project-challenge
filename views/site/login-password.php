<?php

/* @var $this app\components\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\components\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->addTitle('Change your Password');

$this->params['breadcrumbs'][] = 'Change Password';
?>
<div class="site-login">
    <h1>Change your Password</h1>
    <hr />
    <div class="row">
    	<div class="col-xs-8 col-xs-offset-2">
		    <div class="alert alert-warning">You are using a temporary password for logging in. You need to change your password to continue.</div>
		    
	    <?php $form = ActiveForm::begin([
		        'id' => 'change-password-form',
		        'layout' => 'horizontal',
		        'fieldConfig' => [
		            'template' => "{label}\n<div class=\"col-xs-10\">{input}</div>\n<div class=\"col-xs-10 col-xs-offset-2\">{error}</div>",
		            'labelOptions' => ['class' => 'col-xs-2 control-label'],
		        ],
	    ]); ?>
	
	
	        <?php echo $form->field($model, 'password')->passwordInput(); ?>
	
	        <div class="form-group text-center">
	                <?php echo Html::submitButton('Change Password & Continue', ['class' => 'btn btn-success btn-lg', 'name' => 'change-password-button']) ?>
	        </div>
	
	    <?php ActiveForm::end(); ?>
    	</div>
    </div>
</div>
