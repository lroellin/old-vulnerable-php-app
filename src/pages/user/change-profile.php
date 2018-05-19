<?php $title = "Profil bearbeiten"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<script>
// We do a lazy validation. It may still fail in the PHP validation, this is just to ensure that we don't get complete garbage
function validateForm()
{	
	return true;
}
</script>
<?
$accesslevel = User_Accesslevel::Registered;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{
		echo "<form action='changing-profile' method='post' onSubmit='return validateForm()'>";
			dr_print_input("Nickname", "", "", "nickname", "text", $user_info['name'], "", "required");
			
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
