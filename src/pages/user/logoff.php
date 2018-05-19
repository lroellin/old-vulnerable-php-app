<?php $title = "Abmelden"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
	<?
	$_SESSION = Array();
	
	session_destroy();
	
	dr_redirect();
	?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
