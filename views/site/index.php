<?php

use yii\helpers\Url;
use app\components\Helper;

/* @var $this \app\components\View */
/* @var $article \app\models\Article */

$this->addTitle('You daily source of news');

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>News Portal</h1>
        <p class="lead">You daily source of news.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-xs-12">
            	<h2>Latest News</h2>
            </div>
        </div>
        <div class="row">
        <?php if (count($articles)) : ?>
        	<?php foreach ($articles as $article) : ?>
        	<article class="col-xs-12">
        		<h3><a href="<?php echo Url::to('/article/' . $article->id, true); ?>"><?php echo $article->title;?></a></h3>
        		<p>Published at: <?php echo Helper::mysql2date($article->published_at); ?>
        		<p><?php echo trim($article->excerpt) ? nl2br($article->excerpt) : Helper::str_truncate(strip_tags($article->text), 50); ?></p>
	        	<hr>
        	</article>
        	<?php endforeach; ?>
        <?php else : ?>
        	<div class="alert alert-warning col-xs-12">We do not have registered news yet. You can <a href="/register">register and write</a> one for us :)</div>
        <?php endif; ?>
        </div>
    </div>
</div>
