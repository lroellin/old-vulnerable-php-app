<?php $title = "PathEdit"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<? $AppVersion = "1.0.0"; ?>
<p> Hilft, die %PATH%-Variable unter Windows zu ändern.
<h1>Screenshots</h1>
<? dr_makethumbnail("/media/img/apps/windows/PathEdit/PathEdit_Main.png", "Hauptansicht", "PathEdit",400); ?>
<p> Die Hauptansicht des Programms.</p>
<? dr_makethumbnail("/media/img/apps/windows/PathEdit/PathEdit_Edit.png", "Pfad hinzufügen/ändern", "PathEdit",400); ?>
<p>Hinzufügen oder ändern eines Pfads</p>
<h1>Systemvoraussetzungen</h1>
<ul>
	<li>Windows Vista/7/8 (XP nicht getestet)</li>
	<li>.NET Framework 2.0</li>
	<li>Administrator-Rechte (für PATH-Änderung)</li>
</ul>
<h1>Download</h1>
<p>Du findest die aktuellste Version <a href="/dl/PathEdit/PathEdit_<? echo $AppVersion; ?>.exe">hier</a>.</p>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
