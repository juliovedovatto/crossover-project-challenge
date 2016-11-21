<?php

/* @var $this \app\components\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$nav_items = [
	['label' => 'Home', 'url' => ['/']],
	['label' => 'Articles', 'url' => ['/articles']],
];

if ($this->isUserLoggedIn())
	$nav_items[] = ['label' => 'My Articles', 'url' => ['/my-articles']];
		
$nav_items[] = ['label' => 'Submit Your Article', 'url' => ['/submit-article']];

if ($this->isUserLoggedIn()) {
	$nav_items[] = '<li>'
		. Html::beginForm(['/logout'], 'post')
		. Html::submitButton(
		    'Logout (' . Yii::$app->getUser()->identity->name . ')',
		    ['class' => 'btn btn-link logout']
		)
		. Html::endForm()
		. '</li>';
} else {
	$nav_items[] = ['label' => 'Login', 'url' => ['/login']];
	$nav_items[] = ['label' => 'Register', 'url' => ['/register']];
}


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->getTitle()) ?></title>
    <?php $this->head() ?>
    <link rel="alternate" type="application/rss+xml" title="RSS feed" href="/rss.xml" />
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
<?php
    NavBar::begin([
        'brandLabel' => 'News Portal',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget(['options' => ['class' => 'navbar-nav navbar-right'], 'items' => $nav_items]);
    NavBar::end();
?>

    <div class="container">
        <?php echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    <?php if ($this->getSuccessFlash()) : ?>
        <div class="alert alert-success"><?php echo $this->getSuccessFlash(); ?></div>
	<?php endif; ?>
    <?php if ($this->getErrorFlash()) : ?>
        <div class="alert alert-danger"><?php echo $this->getErrorFlash(); ?></div>
	<?php endif; ?>
        <?php echo $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; News Portal <?php echo date('Y') ?></p>

        <p class="pull-right"><?php echo Yii::powered() ?> - Developed by <a href="mailto:juliovedovatto@gmail.com">Julio Vedovatto</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
