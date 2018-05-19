<?php $title = "Profil"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<?
	$accesslevel = User_Accesslevel::Registered;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{
		dr_getgravatar($user_info['email'], 100);
		$accesslevelname = dr_getaccesslevelname($user_info);
		echo "<h1 class='inline pull-right'>{$user_info['name']} <small>$accesslevelname</small></h1>";
		
		echo "<p>";
			echo "<a class='btn btn-default' href='/user/change-profile'>Profil bearbeiten</a>&nbsp;";
			echo "<a class='btn btn-default' href='/user/change-credentials'>Anmeldeinformationen ändern</a>";
		echo "</p>";
		
		// Infos
		echo "<table class='table table-striped table-responsive'>";
			echo "<tr>";
				echo "<td>E-Mail</td>";
				echo "<td>{$user_info['email']}</td>";
			echo "</tr>";
		echo "</table>";
	}
	else
	{
		dr_print_notpermitted("", "");
	}
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>

