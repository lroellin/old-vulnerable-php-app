<?php
// Maintenance mode, get time and error reporting
// ==================================================
// Get starttime
$starttime = microtime(true);

// Error reporting
$debug = false;
if($debug)
{
	error_reporting(E_ALL);
}
else
{
	error_reporting(E_ALL ^ E_NOTICE);
}
ini_set('display_errors', True);

// Functions and Enums
// ==================================================
require("{$_SERVER['DOCUMENT_ROOT']}/inc/functions.php");
require("{$_SERVER['DOCUMENT_ROOT']}/inc/enums.php");

// Session setup
// ==================================================
session_start();
// DBO for all pages
$db = new PDO('mysql:host=mysql;dbname=main;charset=utf8', 'main', 'YhXgSdHw9gT8tptMdRge');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
// Determine user infos
// If the user is logged in
if($_SESSION['logged_in'])
{
	$userstmt = $db->prepare("SELECT * FROM user_user WHERE id_user_user=:id");
	$userstmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
	$userstmt->execute();
	$user_info = $userstmt->fetchAll(PDO::FETCH_ASSOC);
	$user_info = $user_info[0];
}
// If not logged in or unregistered, give ID of the actual "Unregistered" user
else
{
	$user_info['id_user_user'] = 0;
}
// Determine access level
$user_accesslevel = dr_getaccesslevel($user_info);

// Versions
$vBootstrap = "3.3.1";
$vFontAwesome = "4.2.0";
$vjQuery = "2.1.1";
// Password algorithm
$passwordalgorithm = PASSWORD_BCRYPT;

?>
<!DOCTYPE HTML>
<html>
<head>	
	<?php
	echo "<title>$title | Dreamis Webseite</title>"
	?>
	
	<!-- Charset -->
	<meta charset="utf-8">
	<!-- Favicon -->
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	
	<!-- Google Site Verification -->
	<meta name="google-site-verification" content="gIxiFem1qZenjycKaRXprf8sWPlttLD87EG0T5Izxr8" />
	
	<!-- Stylesheet -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Font -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<!-- Bootstrap stylesheet -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/<? echo $vBootstrap ?>/css/bootstrap.min.css">
	<!-- Icons -->
	<link href="//netdna.bootstrapcdn.com/font-awesome/<? echo $vFontAwesome ?>/css/font-awesome.min.css" rel="stylesheet">
	 <!-- Lightbox -->
	<link rel="stylesheet" href="/style/lightbox.css" />
	<!-- Custom stylesheet -->
	<link rel="stylesheet" href="/style/style.css" />
	
	<!-- Script -->
	<!-- jQuery (required by Bootstrap, therefore first -->
	<script src="//code.jquery.com/jquery-<? echo $vjQuery ?>.min.js"></script>
	<!-- Bootstrap -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/<? echo $vBootstrap ?>/js/bootstrap.min.js"></script>
	 <!-- Lightbox -->
	<script src="/script/lightbox-2.6.min.js"></script>
	<!-- 3rd party -->
	<script src="/script/3rdparty-script.js"></script>
	<!-- Custom script -->
	<script src="/script/script.js"></script>
</head>
<!-- Body -->
<body>
	<a href="#page-title" class="sr-only">Skip to main content</a>
	<? require("{$_SERVER['DOCUMENT_ROOT']}/inc/header.php"); ?>
	<div class='container'>
	<?php
	print "<h1 class='page-header' id='page-title'>$title</h1>";
	?>
	
