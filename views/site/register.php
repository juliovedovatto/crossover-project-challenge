<?php

/* @var $this app\components\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->addTitle('Register new Account');
$this->params['breadcrumbs'][] = 'Register';
?>
<div class="site-contact">
    <h1>Register New Account</h1>
    <hr>
    <div class="row">
    	<div class="col-xs-8 col-xs-offset-2">
    		<?php $form = ActiveForm::begin([
		        'id' => 'register-form',
		        'layout' => 'horizontal',
		        'fieldConfig' => [
		            'template' => "{label}\n<div class=\"col-xs-10\">{input}</div>\n<div class=\"col-xs-10 col-xs-offset-2\">{error}</div>",
		            'labelOptions' => ['class' => 'col-xs-2 control-label'],
		        ],
		    ]); ?>
	
	        <?php echo $form->field($model, 'name')->textInput(['autofocus' => true]); ?>
	        <?php echo $form->field($model, 'email')->textInput(); ?>
	        
			<div class="form-group text-center">
                <?php echo Html::submitButton('Register', ['class' => 'btn btn-success btn-lg', 'name' => 'register-button']) ?>
	        </div>
	
	    	<?php ActiveForm::end(); ?>
    	</div>
    </div>
    <div class="row">
    	<div class="alert alert-info">After registration, you will be emailed with a temporary password to login.</div>
    </div>
</div>
