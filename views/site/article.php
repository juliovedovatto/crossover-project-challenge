<?php

/* @var $this \app\components\View */
/* @var $article \app\models\Article */

$this->addTitle($article->title);
$this->addTitle('Article');

use \app\components\Helper;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="site-article">
    <div class="body-content">
    	<article id="<?php echo $article->id; ?>">
    		<h1>
        		<?php echo $article->title; ?>
        		<?php if ($this->isLoggedUserAdmin()) : ?>
        			<?php if ($article->status == $article::STATUS_DISABLED) : ?>
        			<span class="label label-default" style="font-size: 11px; font-weight: normal;">Disable</span> 
        			<?php elseif ($article->status == $article::STATUS_MODERATION) : ?>
        			<span class="label label-default" style="font-size: 11px; font-weight: normal;">Awating Moderation</span> 
        			<?php endif; ?>
        		<?php endif; ?>
			</h1>
			<div class="row">
				<div class="col-xs-3">
						Published at:
					<?php if ($article->published_at && $article->published_at !== Helper::NULL_DATETIME) : ?>
						<?php echo Helper::mysql2date($article->published_at); ?>
					<?php else : ?>
						<span class="label label-info" style="font-size: 11px; font-weight: normal;">Not published yet</span> 				
					<?php endif; ?>
				</div>
				<?php if ($this->isLoggedUserAdmin()) : ?>
				<div class="col-xs-3 text-center">
					Created at: <?php echo Helper::mysql2date($article->created_at, 'm/d/Y H:i:s'); ?> 
				</div>
				<div class="col-xs-3 text-right">
					Updated at: <?php echo Helper::mysql2date($article->created_at, 'm/d/Y H:i:s'); ?> 
				</div>
				<div class="col-xs-3 text-right">
					Written by: <?php echo $article->user->name; ?> 
				</div>
				<?php else : ?>
				<div class="pull-right text-right">
					Written by: <?php echo $article->user->name; ?> 
				</div>
				<?php endif; ?>
			</div>
			<hr>
			<p><?php echo Html::img(Url::to($article->picture, true), array('alt' => $article->title, 'class' => 'img-thumbnail img-responsive')); ?></p>
			<?php echo $article->text; ?>
    	</article>
    	<hr>
    	<?php if ($this->isLoggedUserAdmin()) : ?>
    	<div class="panel panel-info">
    		<div class="panel-heading"><h4>Admin: Avaliable Actions</h4></div>
    		<div class="panel-body text-center">
			    <a href="/article/delete/<?php echo $article->id; ?>" class="btn btn-lg btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete Article</a>
			    <a href="/article/approve/<?php echo $article->id; ?>" class="btn btn-lg btn-success"><span class="glyphicon glyphicon-thumbs-up"></span> Approve Article</a>
			    <a href="/article/disable/<?php echo $article->id; ?>" class="btn btn-lg btn-warning"><span class="glyphicon glyphicon-thumbs-down"></span> Disable Article</a>
			</div>
    	</div>
    	<?php elseif ($this->getLoggedUser() && $article->id_user == $this->getLoggedUser()->id) : ?>
    	<div class="panel panel-info">
    		<div class="panel-heading"><h4>Avaliable Actions</h4></div>
    		<div class="panel-body text-center">
			    <a href="/article/delete/<?php echo $article->id; ?>" class="btn btn-lg btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete Article</a>
			</div>
    	</div>
    	<?php endif; ?>
    	<div class="text-center" style="maring-top: 20px;">
			<a href="/article/download/<?php echo $article->id; ?>" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-download"></span> Download PDF of Article</a>
    		<a href="/articles" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-book"></span> Read more Articles</a>
    	</div>
    </div>
</div>
