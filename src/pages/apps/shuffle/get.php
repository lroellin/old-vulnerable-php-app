<?php $title = "Mischen" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<? $separatorchars = array("\r\n", " ", ",", ";", "\t"); ?>
<p>Mischt Einträge, getrennt durch ein gegebenes Trennzeichen.</p>
<form method="POST">
	<label for="shuffle">Eingabe</label>
	<textarea name="shuffle" id="shuffle" class="form-control"></textarea>
	<p></p>
	<label for="separator">Trennzeichen</label>
	<select name="separator" id="separator" class="form-control">
		<?php
			foreach($separatorchars as $separatorchar)
			{
				// Format number
				$separatorcharname = dr_getcharname($separatorchar);
				print "<option value='$separatorchar'>$separatorcharname</option>";
			}
		?>
	</select>
	<p></p>
	<p><button type="submit" class="btn btn-primary">Senden</button>
</form>
<?php
$valid = false;
$received = false;
// Get IP
if($_POST['shuffle'] AND $_POST['separator'])
{
	$received = true;
	
	if(in_array($_POST['separator'], $separatorchars)  AND (strlen($_POST['shuffle']) <= 100000))
	{
		$valid = true;
		$separator = $_POST['separator'];
	}
}

if($received)
{
	if($valid)
	{	
		$explode = explode($_POST['separator'], $_POST['shuffle']);
		
		$count = count($explode);
		
		echo "<p>Anzahl: $count</p>";
			
		echo "<h2>Vorher</h2>";
		echo "<ol>";
		foreach($explode as $explodepart)
		{
			echo "<li>$explodepart</li>";
		}
		echo "</ol>";
		
		for($i = 0; $i <= 100; $i++)
		{
			shuffle($explode);
		}
		
		echo "<h2>Nachher</h2>";
		echo "<ol>";
		foreach($explode as $explodepart)
		{
			echo "<li>$explodepart</li>";
		}
		echo "</ol>";
		
		
	}
	else
	{
		dr_print_notvalid();
	}
}
?>	
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>