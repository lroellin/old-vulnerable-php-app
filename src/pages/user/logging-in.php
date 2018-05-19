<?php $title = "Anmelden"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<?
	$valid = 0;
	
	
	// Validation
	// Is it given and seems ok?
	if(isset($_POST['username']) and isset($_POST['password']))
	{
		$received = 1;
		$valid = 1;
	}
	
	if($received and $valid)
	{
		// Ok, we'll try to query our user
		$searchstmt = $db->prepare("SELECT * FROM user_user WHERE name=:name");
		$searchstmt->bindValue(':name', $_POST['username'], PDO::PARAM_STR);
		$searchstmt->execute();
		$users = $searchstmt->fetchAll(PDO::FETCH_ASSOC);
		
		// Ok, we found a user
		$user = $users[0];
		
		// Let's verify his password
		if(password_verify($_POST['password'],$user['password']))
		{
			
			$_SESSION['id'] = $user['id_user_user'];
			$_SESSION['logged_in'] = true;
			
			dr_redirect();
		}
		else
		{
			echo "<div class='alert alert-danger'>";
				echo "<strong>Benutzername oder Passwort falsch!</strong> Sorry, versuchs nochmal.<br>";
				echo "<a href='/user/login' class='alert-link'>Zurück</a>";
			echo "</div>";

		}
	}
	else
	{
		dr_print_notvalid();
	}
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
