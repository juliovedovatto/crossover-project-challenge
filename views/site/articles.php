<?php

/* @var $this \app\components\View */
/* @var $article \app\models\Article */

use app\components\View;
use \app\components\Helper;


$this->addTitle((isset($my) ? 'My ' : '') . 'Articles');

?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-xs-12">
            	<h2><?php echo (isset($my) ? 'My' : 'Latest')?> Articles</h2>
            </div>
        </div>
        <div class="row">
        <?php if (count($articles)) : ?>
        	<?php foreach ($articles as $article) :  ?>
        	<article id="article-<?php echo $article->id ?>">
        		<h3>
        			<a href="/article/<?php echo $article->id; ?>"><?php echo $article->title; ?></a>
        		<?php if ($this->isLoggedUserAdmin() || isset($my)) : ?>
        			<?php if ($article->status == $article::STATUS_DISABLED) : ?>
        			<span class="label label-default" style="font-size: 11px; font-weight: normal;">Disable</span> 
        			<?php elseif ($article->status == $article::STATUS_MODERATION) : ?>
        			<span class="label label-default" style="font-size: 11px; font-weight: normal;">Awating Moderation</span> 
        			<?php endif; ?>
        		<?php endif; ?>
        		</h3>
        		
        		<?php if (trim($article->excerpt)) : ?>
        		<p class="help-block"><?php echo $article->excerpt; ?></p>
        		<?php endif; ?>
        		
        		<div class="text-left">
        			<a href="/article/<?php echo $article->id; ?>">Read more..</a>
        		</div>
        	</article>
        	<hr>
        	<?php endforeach;?>
        <?php else : ?>
        	<?php if (isset($my)) : ?>
        	<div class="alert alert-warning col-xs-12">You have not submitted any articles yet. You can <a href="/submit-article">write</a> one for us :)</div>
        	<?php else : ?>
        	<div class="alert alert-warning col-xs-12">We do not have registered news yet. You can <a href="/register">register and write</a> one for us :)</div>
        	<?php endif; ?>
        <?php endif; ?>
        </div>
    </div>
</div>
