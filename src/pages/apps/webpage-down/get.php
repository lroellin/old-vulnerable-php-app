<?php $title = "Webseite erreichbar?" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>

<p>Checkt ob eine Seite erreichbar ist und zeigt Informationen zur Verbindung an.</p>
<?php
$httpcodefile = "{$_SERVER['DOCUMENT_ROOT']}/pages/apps/webpage-down/http-status-codes-1.csv";
dr_showlastmodified($httpcodefile, "HTTP-Statuscode");
?>
<form method="get">
	<? dr_print_input("URL", "www.dreami.ch", "", "url", "text", "", "autofocus"); ?>
	<button type="submit" class="btn btn-primary">Senden</button>
</form>
<?php
$valid = false;
$received = false;
$responseok = false;;
$timeout = 10;

// Validation
if(isset($_GET['url']))
{
	$received = true;
	
	if($url = dr_isurl($_GET['url']))
	{
		$valid = true;
	}
}

if($received)
{
	if($valid)
	{
		// Ok, it is valid

		// Time to check the URL		
		// Initialize curl
		$curl = curl_init($url);
		// Set options
		curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,$timeout);
		curl_setopt($curl,CURLOPT_HEADER,true);
		curl_setopt($curl,CURLOPT_NOBODY,true);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

		// Get response
		$response = curl_exec($curl);

		$info = curl_getinfo($curl);

		print "<p>URL: <a href='{$url}' target='webpage-down'>{$url}</a> ({$info['primary_ip']})</p>";

		curl_close($curl);
		if($response)
		{
			echo "<div class='alert alert-success'>";
			echo "Erreichbar!<br>";
			$responseok = true;
		}
		else
		{
			echo "<div class='alert alert-danger'>";
			echo "Nicht erreichbar nach $timeout Sekunden!<br>";
		}
		echo "</div>";

		if($responseok)
		{
			if($matches = dr_searchstring($httpcodefile, $info['http_code']))
			{
				$match = $matches[0][0];

				$matchcsv = str_getcsv($match,",");
				$code_meaning = $matchcsv[1];

			}

			echo "<table class='table table-striped'>";
				echo "<tr>";
					echo "<td>Zeit</td>";
					echo "<td>{$info['total_time']}s";
					if($info['total_time'] <= 2)
					{
						echo " <span class='label label-success pull-right'>Gut!</span>";
					}
					else
					{
						echo " <span class='label label-warning pull-right'>Langsam</span>";
					}
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>HTTP-Code</td>";
					echo "<td>{$info['http_code']} ({$code_meaning})";
					if($info['http_code'] < 400)
					{
						echo " <span class='label label-success pull-right'>Gut!</span>";
					}
					else if($info['http_code'] < 500)
					{
						echo " <span class='label label-warning pull-right'>Client-Fehler</span>";
					}
					else
					{
						echo " <span class='label label-warning pull-right'>Server-Fehler</span>";
					}
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>Content Type und Charset</td>";
					echo "<td>{$info['content_type']}</td>";
				echo "</tr>";
			echo "</table>";
		}

	}
	else
	{
		dr_print_notvalid();
	}
}
?>
<p>User erwarten eine Ladezeit von weniger als 2 Sekunden</p>
<hr>
Basis-Code von <a href="http://css-tricks.com/snippets/php/check-if-website-is-available/" target="css-tricks">CSS-Tricks</a><br>
Datenbasis von der <a href="http://www.iana.org/assignments/http-status-codes/http-status-codes-1.csv" target="iana">IANA</a>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>