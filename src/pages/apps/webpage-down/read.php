<?php $title = "Webseite erreichbar?" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>Checkt ob eine Seite erreichbar ist und zeigt Informationen zur Verbindung an.</p>
<form action="get" method="get">
	<? dr_print_input("URL", "www.dreami.ch", "", "url", "text", "", "autofocus"); ?>
	<button type="submit" class="btn btn-primary">Senden</button>
</form>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>