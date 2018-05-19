<?php $title = "IP" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>Bestimmt Informationen über eine gegebene IP. Standardmässig ist das die eigene (öffentliche) IP, aber auch andere IPs sind möglich.</p>
<form method="GET">
	<? dr_print_input("IP oder URL", "78.47.72.110 oder www.dreami.ch", "Der Anbieter unterstützt leider nur IPv4, private und reservierte Adressen sind nicht erlaubt.", "ip", "text"); ?>
	<p><button type="submit" class="btn btn-primary">Senden</button>&nbsp;<a href="./" class="btn btn-default">Eigene IP</a></p>
</form>
<?php
$valid = false;
$received = false;
// Get IP
if($_GET['ip'])
{
	$ip = $_GET['ip'];
}
else
{
	$ip = $_SERVER['REMOTE_ADDR'];	
}

// Get IP of the input
if($ip)
{
	$received = true;
	
	if($ip = dr_getip($ip))
	{
		$valid = true;
	}
}	


if($received)
{
	if($valid)
	{
		// Get information in JSON
		
		// Subsubsubing this information...
		// PHP must have been created by Nokia Usability Engineers
		$ctx = stream_context_create
		(
			array
			(
				'http' => array
				(
					'timeout' => 5
				)
			)
		);
		
		
		@$file = file_get_contents("http://ipinfo.io/{$ip}",0,$ctx);
		if(!$file === FALSE)
		{
			$details = json_decode($file);

			// Create location string
			$location = "";
			$location = isset($details->country) ? "{$details->country}" : $location;
			$location = isset($details->region) ? "{$details->region}, $location" : $location;
			$location = isset($details->city) ? "{$details->city}, $location" : $location;

			// Create latitude/longitude
			$ll = str_replace(",", "/", $details->loc);

			// Create country lowercase-string
			$country_lower = strtolower($details->country);

			// Get AS
			$as = explode(" ", $details->org);
			$as = $as[0];
			echo "<table class='table table-striped'>";
				echo "<tr>";
					echo "<td>IP</td>";
					echo "<td>$details->ip</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>Hostname (rDNS)</td>";
					echo "<td>$details->hostname</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>AS</td>";
					echo "<td>$details->org (<a href='https://apps.db.ripe.net/search/query.html?searchtext=${as}&amp;grssources=RIPE' target='ripe'>RIPE</a>)</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>Ort</td>";
					echo "<td><img src='/media/img/flags/{$country_lower}.png' alt='flag-{$country_lower}'> $location ({$ll}, <a href='https://maps.google.com/?ll={$details->loc}' target='google-maps'>Google Maps</a>)</td>";
				echo "</tr>";
			echo "</table>";
		}
		else
		{
			echo "<div class='alert alert-danger'>";
				echo "<strong>Achtung!</strong> Daten können nicht abgerufen werden<br>";
			echo "</div>";
		}
	}
	else
	{
		dr_print_notvalid();
	}
}
?>
<hr>
<p>
	Informationen von <a href="http://ipinfo.io/">ipinfo.io</a><br>
</p>

<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>