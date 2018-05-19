<?php $title = "Registrieren"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<?
	$valid = 0;
	
	
	// Validation
	// Is it given and seems ok?
	if(isset($_POST['nickname']) and isset($_POST['email']) and isset($_POST['password_1']) and isset($_POST['password_2']) and isset($_POST['captcha']) and isset($_POST['captcha_factor_1']) and isset($_POST['captcha_factor_2']))
	{
		$received = 1;
		
		
	}
	
	$accesslevel = User_Accesslevel::Unregistered;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{
		if($received == 1)
		{		
			
			// Are both new passwords the same?
			if($_POST['password_1'] == $_POST['password_2'])
			{
				$passwords_equivalent = 1;
				
				$password = $_POST['password_1'];
				
			}
			
			// Is the nickname ok?
			if(dr_checknickname($_POST['nickname']))
			{
				$nickname_correct = 1;
			}
			
			// Is the email ok?
			if(dr_checkemail($_POST['email']))
			{
				$email_correct = 1;
			}
			
			// Is the CAPTCHA correctly solved?
			if($_POST['captcha_factor_1']*$_POST['captcha_factor_2'] == $_POST['captcha'])
			{
				$captcha_correct = 1;
			}
			
			if($passwords_equivalent == 1 AND $nickname_correct == 1 AND $email_correct == 1 AND $captcha_correct == 1)
			{
				$valid = 1;
			}
				
			if($valid == 1)
			{
				// Get password hash
				$password_hash = password_hash($password, $passwordalgorithm);
				
				
				// Get user accesslevel
				$accesslevel = dr_getaccesslevelid(User_Accesslevel::Registered);
				
				
				
				// Insert stuff
				$userregisterstmt = $db->prepare
				("
					INSERT INTO user_user (name, email, password, fk_user_accesslevel)
					VALUES (:name, :email, :password, :accesslevel);
				");
				$userregisterstmt->bindValue(':name', $_POST['nickname'], PDO::PARAM_STR);
				$userregisterstmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
				$userregisterstmt->bindValue(':password', $password_hash, PDO::PARAM_STR);
				$userregisterstmt->bindValue(':accesslevel', $accesslevel, PDO::PARAM_STR);
				$userregisterstmt->execute();
				
				
				dr_redirect("/user/login", 5000);
			}
			else
			{
				dr_print_notvalid("Entweder ist der Nickname bereits vergeben oder entspricht nicht den Richtlinien, die E-Mailadresse wird bereits verwendet oder die Passwörter stimmen nicht überein.");
			}
			
			
			
			
		}
	}
	else
	{
		dr_print_notpermitted("", "");
	}
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
