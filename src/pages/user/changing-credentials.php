<?php $title = "Anmeldeinformationen ändern"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<?
	$valid = 0;
	
	
	// Validation
	// Is it given and seems ok?
	if(isset($_POST['old_password']) and isset($_POST['new_password_1']) and isset($_POST['new_password_2']) and isset($_POST['new_email_1']) and isset($_POST['new_email_2']))
	{
		$received = 1;
	}
	
	$accesslevel = User_Accesslevel::Registered;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{
		if($received == 1)
		{
			// Is the password correct
			if(dr_checkpassword($user_info, $_POST['old_password']))
			{				
				$password_correct = 1;
			}
			
			// Are both new passwords the same?
			if($_POST['new_password_1'] == $_POST['new_password_2'])
			{
				$passwords_equivalent = 1;
				
				$new_password = $_POST['new_password_1'];
			}
			
			// Are both e-mail addresses the same?
			if($_POST['new_email_1'] == $_POST['new_email_2'])
			{
				$emails_equivalent = 1;
				
				$new_email = $_POST['new_email_1'];
			}
			
			if($password_correct == 1 AND $passwords_equivalent == 1 AND $emails_equivalent == 1)
			{
				$valid = 1;
			}
				
			if($valid == 1)
			{
				echo "<ul>";
				
				// Is a new password given?
				if(!(empty($new_password)))
				{
					echo "<li>Passwort soll geändert werden</li>";
					
					// Ok, is this a new valid password?
					if(dr_checknewpassword($new_password))
					{
						$new_password_hash = password_hash($new_password, $passwordalgorithm);
													
						// Let's update it	
						$passwordstmt = $db->prepare("UPDATE user_user SET password=:password WHERE user_user.id_user_user=:id");
						$passwordstmt->bindValue(':password', $new_password_hash, PDO::PARAM_STR);
						$passwordstmt->bindValue(':id', $user_info['id_user_user'], PDO::PARAM_STR);
						$passwordstmt->execute();
						
						echo "<li>Passwort geändert</li>";
					}
					else
					{
						dr_print_notvalid("Das Passwort muss mindestens 8 Zeichen lang sein.");
					}
				}
				
				// Is a new email given?
				if(!($new_email == $user_info['email']))
				{
					echo "<li>E-Mail soll geändert werden</li>";
					
					// Is this a new valid email?
					if(dr_checkemail($new_email))
					{
						
						// Let's update it	
						$emailstmt = $db->prepare("UPDATE user_user SET email=:email WHERE user_user.id_user_user=:id");
						$emailstmt->bindValue(':email', $new_email, PDO::PARAM_STR);
						$emailstmt->bindValue(':id', $user_info['id_user_user'], PDO::PARAM_STR);
						$emailstmt->execute();
						
						echo "<li>E-Mail wurde geändert</li>";
					}
					else
					{
						dr_print_notvalid("Hast du dich mit dieser E-Mail bereits registriert?");
					}
					
				}
				
				echo "</ul>";
				dr_redirect("/user/profile", 5000);
			}
			else
			{
				dr_print_notvalid("Das neue Passwort bzw. die neue E-Mailadresse muss übereinstimmen.");
			}	
			
						
			
		}
	}
	else
	{
		dr_print_notpermitted("", "");
	}
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
