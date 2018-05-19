<?php $title = "Dell-Konverter" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>Berechnet den Express-Code eines Service-Tags vor und zurück.</p>
<script>
function readServicetag(form)
{
	// Read form
	servicetag = form.servicetag_input.value;
	
	// Convert to uppercase
	servicetag = servicetag.toUpperCase();
	
	// Validation
	// Regex
	var patt = new RegExp(/^[a-z0-9]+$/i);
	if(!((patt.test(servicetag)) && (servicetag.length >= 5) && (servicetag.length <= 7)))
	{
		throwError();
	}

	hideWarning("#alert-data");
	
	getExpressservicecode(servicetag)
}

function getExpressservicecode(servicetag)
{
	expressservicecode = parseInt(servicetag,36);
	expressservicecode = expressservicecode.toString();
	
	// Add dashes
	expressservicecodearray = expressservicecode.match(/.{1,3}/g);
	expressservicecode = expressservicecodearray.join("-");
	
	
	showResult(expressservicecode, "#expressservicecode", "#expressservicecode-text");
}

function readExpressservicecode(form) {

	// Read form
	expressservicecode = form.expressservicecode_input.value;
	
	// Leave out dashes (normalize)
	expressservicecode = expressservicecode.replace(/-/gi, '');
	
	
	// Validation
	if(!(($.isNumeric(expressservicecode)) && (expressservicecode.length >= 9) && (expressservicecode.length <= 11)))
	{
		throwError();
	}
	
	hideWarning("#alert-data");

	getServicetag(expressservicecode)
}

function getServicetag(expressservicecode)
{
	// Convert this string to an integer again
	expressservicecode = parseInt(expressservicecode,10);
	
	// Convert it back to string
	servicetag = expressservicecode.toString(36)
	
	// Service tags are all uppercase
	servicetag = servicetag.toUpperCase();
	
	showResult(servicetag, "#servicetag", "#servicetag-text");
}
</script>

<h1>Express-Servicecode berechnen</h1>
<form>
	<? dr_print_input("Servicetag", "J9YT9G1", "", "servicetag_input", "text"); ?>
	<button type="button" class="btn btn-primary" onClick="readServicetag(this.form)">Berechnen</button><br>
</form>
<? dr_print_success("Ergibt", "", "expressservicecode", "expressservicecode-text"); ?>

<h1>Servicetag berechnen</h1>
<form>
	<? dr_print_input("Express-Servicecode", "419-615-321-77", "mit oder ohne Bindestriche", "expressservicecode_input", "text"); ?>
	<button type="button" class="btn btn-primary" onClick="readExpressservicecode(this.form)">Berechnen</button><br>
</form>
<? dr_print_success("Ergibt", "", "servicetag", "servicetag-text"); ?>
<? dr_print_notvalid("", "hidden"); ?>
<hr>
<p>
	Dieses Tool steht nicht im Zusammenhang mit Dell Inc.
</p>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>