<?php $title = "Registrieren"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<script>
// We do a lazy validation. It may still fail in the PHP validation, this is just to ensure that we don't get complete garbage
function validateForm()
{
	// Are both passwords the same?
	if(!(($('#password_1').val()) == $('#password_2').val()))
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
$accesslevel = User_Accesslevel::Unregistered;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{
		echo "<p>Die Registrierung ist völlig freiwillig und bringt dir keine weiteren Apps oder ähnliches. Der Benutzerteil ist auch eine technische Spielerei, aber wenn du dich dafür interessierst, kannst du dich registrieren.</p>";
		echo "<form action='registering' method='post' onSubmit='return validateForm()'>";
			dr_print_input("Benutzername", "", "", "nickname", "text", "", "required");
			dr_print_input("E-Mail", "", "", "email", "text", "", "required");
			dr_print_input("Passwort", "", "", "password_1", "password", "", "required");
			dr_print_input("Passwort wiederholen", "", "", "password_2", "password", "", "required");
			
			// Captcha
			$factor_1 = rand(1, 10);
			$factor_2 = rand(1, 10);
			dr_print_input("CAPTCHA: Was ergibt $factor_1 mal $factor_2?", "", "", "captcha", "text", "", "required");
			dr_print_input("", "", "", "captcha_factor_1", "hidden", "$factor_1", "required");
			dr_print_input("", "", "", "captcha_factor_2", "hidden", "$factor_2", "required");
			
			echo "<p>Die Datenschutzregeln sind ganz einfach: du bekommst keine ungewünschten Nachrichten und deine Adresse wird nicht verkauft <i class='fa fa-smile-o'></i></p>";
			
			
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
