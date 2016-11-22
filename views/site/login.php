<?php

/* @var $this app\components\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\components\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->addTitle('Login');

$this->params['breadcrumbs'][] = 'Login';
?>
<div class="site-login">
    <h1>Login</h1>
    <hr />
    <div class="row">
    	<div class="col-xs-6">
		    <div class="alert alert-info">Not Registered Yet? Feel free to <a href="/register">make one</a> and send an article to us :)</div>
		    <div class="text-center">
			    <a href="/register" class="btn btn-lg btn-info">Register (it's free)</a>
		    </div>
    	</div>
    	<div class="col-xs-6">
	    	<p>Already have a login? Please fill out the following fields:</p>
	
		    <?php $form = ActiveForm::begin([
		        'id' => 'login-form',
		        'layout' => 'horizontal',
		        'fieldConfig' => [
		            'template' => "{label}\n<div class=\"col-xs-10\">{input}</div>\n<div class=\"col-xs-10 col-xs-offset-2\">{error}</div>",
		            'labelOptions' => ['class' => 'col-xs-2 control-label'],
		        ],
		    ]); ?>
	
	        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
	
	        <?= $form->field($model, 'password')->passwordInput() ?>
	
	        <?= $form->field($model, 'rememberMe')->checkbox([
	            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
	        ]) ?>
	
	        <div class="form-group text-center">
	                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button']) ?>
	        </div>
	
	    <?php ActiveForm::end(); ?>
    	</div>
    </div>
</div>
