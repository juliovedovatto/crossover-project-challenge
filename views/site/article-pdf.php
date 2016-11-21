<?php

/* @var $this \app\components\View */
/* @var $article \app\models\Article */

use app\components\Helper;
use yii\helpers\Html;

?><!DOCTYPE html>
<html>
 	<head>
 		<meta charset="utf-8">
 	</head>
 	<body>
 		<h1><?php echo $article->title; ?></h1>
 		<p><?php echo $article->excerpt?></p>
 		<p>
 			<small>Published at: <?php echo $article->published_at ? Helper::mysql2date($article->published_at) : 'Not published yet'; ?></small>
 		</p>
 		<hr>
 		<p><?php echo Html::img(Yii::getAlias('@app') . '/web/' . $article->picture, array('alt' => $article->title)); ?></p>
 		<?php echo $article->text; ?>
 	</body>
 </html>