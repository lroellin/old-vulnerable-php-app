<?php $title = "Anmelden"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<form action="logging-in" method="post">
	<? dr_print_input("Benutzername", "", "", "username", "text"); ?>
	<? dr_print_input("Passwort", "", "", "password", "password"); ?>
	<button type="submit" class="btn btn-primary">Senden</button>
</form>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
