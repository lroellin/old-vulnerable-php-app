<?php $title = "Anmeldeinformationen ändern"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<script>
// We do a lazy validation. It may still fail in the PHP validation, this is just to ensure that we don't get complete garbage
function validateForm()
{
	// Are both passwords the same?
	if(!(($('#new_password_1').val()) == $('#new_password_2').val()))
	{
		$warning = $('#alert-data');
		$warning.show(400);
		return false;
	}
	
	if(!(($('#new_email_1').val()) == $('#new_email_2').val()))
	{
		$warning = $('#alert-data');
		$warning.show(400);
		return false;
	}
	
	hideWarning("#alert-data");
	
	return true;
}
</script>
<?
$accesslevel = User_Accesslevel::Registered;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{
		echo "<p>Du kannst hier dein Passwort und/oder deine E-Mailadresse ändern.<br>Da diese Informationen für die Sicherheit wichtig sind, wird auch dein altes Passwort benötigt.</p>";
		echo "<form action='changing-credentials' method='post' onSubmit='return validateForm()'>";
			dr_print_input("Altes Passwort", "", "", "old_password", "password");
			
			echo "<h1>Passwort ändern</h1>";
			dr_print_input("Neues Passwort", "", "", "new_password_1", "password");
			dr_print_input("Neues Passwort wiederholen", "", "", "new_password_2", "password");
			
			echo "<h1>E-Mail ändern (optional)</h1>";
			dr_print_input("Neue E-Mail", "", "", "new_email_1", "text", $user_info['email']);
			dr_print_input("Neue E-Mail wiederholen", "", "", "new_email_2", "text", $user_info['email']);
			
			dr_print_notvalid("", "hidden");
			
			echo "<button type='submit' class='btn btn-primary'>Senden</button>";
		echo "</form>";
	}
	else
	{
		dr_print_notpermitted("", "");
	}
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
