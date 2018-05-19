<?php $title = "Galerie" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>Meine GFX-Bilder</p>


<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#legal">Rechtliche Hinweise</button>
<div id="legal" class="collapse">
<p>
	Die Autoren der gezeigten Hintergrundbilder haben freundlicherweise die Rechte zur Nutzung und Bearbeitung freigegeben (meistens via Creative Commons). Im Gegenzug werden sie genannt.<br>
	Ich habe versucht, den Autor zu verlinken, kann aber nicht für die Gültigkeit des Links in der Zukunft garantieren. Wenn du der Autor bist und du nicht mehr korrekt verlinkt bist, melde dich doch (siehe <a href='/about/imprint/'>Impressum</a>).<br>
	Ich gebe diese Bilder mit den mir gegebenen Rechten an alle weiter.
<p>
</div>
<?php
$dir = "/media/img/apps/gallery/";


// Get images
$stmt = $db->prepare
("
	SELECT *
	FROM gallery_images
	ORDER BY name
");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
	<div class='row'>
	<?
	// Ok, we'll go through each of them
	$key = 0;
	foreach($results as $result)
	{	
		$filepath = "${dir}{$result['image']}";
		// 3 per row
		if($key %  2 == 0)
		{
			echo "</div><div class='row'>";
		}
		echo "<div class='col-md-6'>";
			// Highlight this box?
			$fragment = parse_url($_SERVER['REQUEST_URI'], PHP_URL_FRAGMENT);
			echo "<div id='{$result['image']}' class='thumbnail";
				if($_GET['f'] == $result['image'])
				{
					echo " highlight";
				}
			echo "'>";
				dr_makethumbnail("$filepath", "{$result['name']}", "gfx",400);
				echo "<h3 class='text-center'>";
					echo "{$result['name']}<br>";
					$youtube_link = urlencode($result['name']);
					$youtube_link = "https://www.youtube.com/results?search_query=$youtube_link";
					echo "<a href='$youtube_link' target='youtube'><i class='fa fa-youtube'></i></a>&nbsp;";
					echo "<a href='?f={$result['image']}#{$result['image']}'><i class='fa fa-link'></i></a>&nbsp;";
					echo "<a href='{$filepath}'><i class='fa fa-download'></i></a><br>";
					echo "<small>Quelle: <a href='{$result['source']}' target='gfx'>{$result['source']}</a></small>";
				echo "</h3>";
			echo "</div>";
		echo "</div>";
		echo "\n";
		$key++;
	}
	?>
	</div>

<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>