<?php

/* @var $this app\components\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Article */

use app\components\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use dosamigos\tinymce\TinyMce;

$this->addTitle('Submit new Article');
$this->params['breadcrumbs'][] = 'Submit Article';
?>
<div class="site-contact">
    <h1>Submit new Article</h1>
    <hr>
    <div class="row">
    	<div class="col-xs-8 col-xs-offset-2">
    		<?php $form = ActiveForm::begin([
		        'id' => 'article-submit-form',
		        'layout' => 'horizontal',
    			'options' => ['enctype' => 'multipart/form-data'],
		        'fieldConfig' => [
		            'template' => "{label}\n<div class=\"col-xs-10\">{input}</div>\n<div class=\"col-xs-10 col-xs-offset-2\">{error}</div>",
		            'labelOptions' => ['class' => 'col-xs-2 control-label'],
		        ],
		    ]); ?>
	
	        <?php echo $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
	        <?php echo $form->field($model, 'excerpt')->textarea(['rows' => 5]); ?>
	        <?php echo $form->field($model, 'text')->widget(TinyMce::className(), [
			    'options' => ['rows' => 6],
			    'language' => 'pt_BR',
			    'clientOptions' => [
			        'plugins' => [
			            "advlist autolink lists link charmap anchor",
			            "insertdatetime media table contextmenu paste"
			        ],
			    	'menubar' => false,
			    	'statusbar' => false,
			    	'height' => 280, 
			        'toolbar' => "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | undo redo"
			    ]
			]);; ?>
	        <?php echo $form->field($model, 'picture')->fileInput(); ?>
	        
			<div class="form-group text-center">
                <?php echo Html::submitButton('Register', ['class' => 'btn btn-success btn-lg', 'name' => 'register-button']) ?>
	        </div>
	
	    	<?php ActiveForm::end(); ?>
    	</div>
    </div>
    <?php if (!$this->isLoggedUserAdmin()) : ?>
    <div class="row">
    	<div class="alert alert-info">After submission, the article will be put under moderation. You will receive email when approved..</div>
    </div>
    <?php endif; ?>
</div>
