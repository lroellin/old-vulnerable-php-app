<?php $title = "Port &rarr; Dienst" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>Bestimmt offizielle Informationen über einen gegebenen Port.</p>
<?php
$portfile = "{$_SERVER['DOCUMENT_ROOT']}/pages/apps/port-lookup/service-names-port-numbers.csv";
dr_showlastmodified($portfile, "Port");
?>
<form method="get">
	<? dr_print_input("Port", "22", "", "port", "text"); ?>
	<button type="submit" class="btn btn-primary">Senden</button>
	<br>
</form>
<?php
$valid = false;
$received = false;

// Validation
// Is it given and seems ok?
if(isset($_GET['port']))
{
	$received = true;
	if(dr_isport($_GET['port']))
	{
		$valid = true;
	}
}
if($received)
{
	if($valid)
	{	
		$type = dr_getporttype($_GET['port']);
		echo "<p>Port: {$_GET['port']} <span class='label label-default'>$type</span></p>";
		
		if($matches = dr_searchstring($portfile, $_GET['port'], ","))
		{
			// We have a match!
			
			// Get it
			$matches = $matches[0];
			
			print "<table class='table table-striped'>";
			print "<tr>";
				print "<th>Dienst</th>";
				print "<th>Nummer</th>";
				print "<th>Beschreibung</th>";
				print "<th>Protokoll</th>";
				print "<th>Referenz</th>";
			print "</tr>";
			
			// Foreach match
			foreach($matches as $match)
			{
				$matchcsv = str_getcsv($match,",");
				
				// Get RFC number (if any)
				$rfc = substr($matchcsv[8],4,-1);
				if($rfc)
				{
					$rfc = dr_getrfclink($rfc);
				}
				else
				{
					$rfc = "";
				}
				
				// Show table
				print "<tr>";
					print "<td>$matchcsv[0]</td>";
					print "<td>$matchcsv[1]</td>";
					print "<td>$matchcsv[3]</td>";
					print "<td>$matchcsv[2]</td>";
					print "<td>";
						echo "$rfc";
					print "</td>";
				print "</tr>";
			}
			
			print "</table>";
		}
		else
		{
			dr_print_notfound("Dynamic-Ports werden nicht registriert.");
		}
	}
	else
	{
		dr_print_notvalid();
	}
}
?>
<hr>
Basis-Code von <a href="http://stackoverflow.com/a/3686246/2616394" target="stackoverflow">Stackoverflow</a><br>
Datenbasis von der <a href="http://www.iana.org/assignments/service-names-port-numbers/service-names-port-numbers.csv" target="iana">IANA</a>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>