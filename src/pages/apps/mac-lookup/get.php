<?php $title = "MAC-Adresse &rarr; Hersteller" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>Bestimmt den zugeteilten Hersteller eines Netzwerkgeräts über den OUI einer MAC-Adresse (nein, das hat nicht Apple erfunden).</p>
<?php
$macfile = "{$_SERVER['DOCUMENT_ROOT']}/pages/apps/mac-lookup/manuf.txt";
dr_showlastmodified($macfile, "MAC"); 
?>
<form  method="get">
	<? dr_print_input("MAC-Adresse", "00:1C:14:01:40:8D", "mit Doppelpunkten oder Bindestrichen getrennt, Gross-/Kleinschreibung egal", "address", "text"); ?>
	<button type="submit" class="btn btn-primary">Senden</button>
	<br>
</form>
<?php
$received = false;
$valid = false;

// Validation
// Is it given and seems ok?
if(isset($_GET['address']))
{
	$received = true;
	if(preg_match('/^([0-9A-F]{2}[:-]){5}([0-9A-F]{2})$/i',$_GET['address']))
	{
		$valid = true;
	}
}
if($received)
{
	if($valid)
	{
		// Normalize
		// Convert dashes to colons if needed
		$address = str_replace("-", ":", $_GET['address']);

		// We only need the vendor part for this
		$address_short = substr($address,0,8);

		if($matches = dr_searchstring($macfile, $address_short))
		{
			// We have a match!
			
			// Get it
			$match = $matches[0][0];
			
			// We need the part after the tab
			$vendor = explode("\t", $match);
			$vendor = $vendor[1];
			
			// Now we need the part before the hash
			$vendor = explode("#", $vendor);
			$vendorshortname = $vendor[0];
			
			// The part after the hash seems to be a fancy name
			$vendorfancyname = $vendor[1];
			// ... that has a space in the first character
			$vendorfancyname = trim($vendorfancyname);
			
			dr_print_success("Die MAC-Adresse $address stammt vom Hersteller", "", "", "", "$vendorshortname ({$vendorfancyname})", false);
		}
		else
		{
			dr_print_notfound();
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
Datenbasis vom <a href="http://anonsvn.wireshark.org/wireshark/trunk/manuf" target="wireshark-manuf">Wireshark Manufacturer File</a>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
