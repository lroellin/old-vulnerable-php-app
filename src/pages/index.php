<?php $title = "Home" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<div class="jumbotron jumbotron-own">
	<h1>Hallo!</h1>
	<p>Willkommen zu meiner privaten Webseite</p>
</div>
<?php
	// If an error is given
	if(!(empty($_GET['error'])))
	{
		echo "<div class='alert alert-danger'>";
			echo "<h1>Upps...</h1>";
			switch($_GET['error'])
			{
				case 403:
					echo "<strong>Fehler 403:</strong> Zugriff verweigert";
					break;
				case 404:
					echo "<strong>Fehler 404:</strong> Seite nicht gefunden";
					break;
				case 500:
					echo "<strong>Fehler 500:</strong> Serverfehler";
					break;
				default:
					echo "<strong>Fehler im Fehler</strong>";
					break;
			}
			echo "<br><br>Versuch es noch einmal. Wenn der Fehler besteht, kontaktiere die E-Mailadresse im <a href='/about/imprint/' class='alert-link'>Impressum</a>";
		echo "</div>";
	}
?>

<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>