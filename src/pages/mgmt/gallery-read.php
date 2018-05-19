<?php $title = "Galerie"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<?
	$accesslevel = User_Accesslevel::Administrator;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{
		echo "<form method='post' action='gallery-upload' enctype='multipart/form-data'>";
			echo "<input name='file' id='file' type='file'><br>";
			dr_print_input("Name", "", "", "name", "text", $input = "", $autofocus="", $required="required");
			dr_print_input("Quelle", "", "", "source", "text", $input = "", $autofocus="", $required="required");
			echo "<button type='submit' class='btn btn-primary'>Senden</button>";
		echo "</form>";
	}
	else
	{
		dr_print_notpermitted("", "");
	}
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>

