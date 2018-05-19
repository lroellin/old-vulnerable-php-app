<?php $title = "Anmeldeinformationen ändern"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<?
	$valid = 0;
	
	
	// Validation
	// Is it given and seems ok?
	if(isset($_POST['nickname']))
	{
		$received = 1;
	}
	
	$accesslevel = User_Accesslevel::Registered;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{
		if($received == 1)
		{	
			// No obvious errors
			$nickname_correct = 1;
			
			if($nickname_correct == 1)
			{
				$valid = 1;
			}
				
			if($valid == 1)
			{
				echo "<ul>";
				
				// Is a new nickname given?
				if(!($_POST['nickname'] == $user_info['name']))
				{
					echo "<li>Nickname soll geändert werden</li>";
					
					// Ok, is this a new valid nickname?
					if(dr_checknickname($_POST['nickname']))
					{														
						// Let's update it	
						$passwordstmt = $db->prepare("UPDATE user_user SET name=:nickname WHERE user_user.id_user_user=:id");
						$passwordstmt->bindValue(':nickname', $_POST['nickname'], PDO::PARAM_STR);
						$passwordstmt->bindValue(':id', $user_info['id_user_user'], PDO::PARAM_STR);
						$passwordstmt->execute();
						
						echo "<li>Nickname geändert</li>";
					}
					else
					{
						dr_print_notvalid("Der Nickname darf nur Buchstaben von A-Z sowie Zahlen enthalten.");
					}
				}
				
				echo "</ul>";
			}
			else
			{
				dr_print_notvalid();
			}
				
			dr_redirect("/user/profile", 5000);
			
			
			
		}
	}
	else
	{
		dr_print_notpermitted("", "");
	}
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
