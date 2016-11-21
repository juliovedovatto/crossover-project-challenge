<?php 
use yii\helpers\Url;

/* @var $user \app\models\User */

?><!DOCTYPE html>
 <html>
 	<head>
 		<meta charset="utf-8">
 		<title>User Registration - News Portal</title>
 	</head>
 	<body>
 		<h1>Hello, <?php echo $user->name; ?></h1>
 		
 		<hr>
 		
 		<p>We are very pleased to have you registered on our site.</p>
 		
 		<p>Your temporary password is: <?php echo $password; ?></p>
 		
 		<p>When you log in to the site with this password, you will be prompted to change it.</p>
 		
 		<p>To log in, simply access the url <a href="<?php echo Url::toRoute('/login', true); ?>"><?php echo Url::toRoute('/login', true); ?></a></p>
 		
 		<p>Feel free to write articles and help us grow even more ;-)</p>
 		
 		<p>Yours, sincerely,<br>
 			<em>News Portal</em>
 		</p>
 	</body>
 </html>