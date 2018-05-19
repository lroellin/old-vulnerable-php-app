<?php $title = "Benutzerverwaltung"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<?
	$accesslevel = User_Accesslevel::Administrator;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{
		$accessstmt = $db->prepare
		("
			SELECT *
			FROM user_user
			INNER JOIN user_accesslevel ON user_user.fk_user_accesslevel = user_accesslevel.id_user_accesslevel
			ORDER BY id_user_user
		");
		$accessstmt->execute();
		$userrows = $accessstmt->fetchAll(PDO::FETCH_ASSOC);
		
		echo "<table class='table table-striped table-responsive'>";
		echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Name</th>";
			echo "<th>E-Mail</th>";
			echo "<th>Zugriffslevel</th>";
		echo "</tr>";
		
		foreach($userrows as $userrow)
		{
			echo "<tr>";
				echo "<td>{$userrow['id_user_user']}</td>";
				echo "<td>{$userrow['name']}</td>";
				echo "<td>{$userrow['email']}</td>";
				echo "<td>{$userrow['access_level']}</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	else
	{
		dr_print_notpermitted("", "");
	}
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>

