<?php $title = "Passwort generieren" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>
	Mit dieser App können Passwörter aus gewünschten Zeichen mit einer bestimmten Länge generiert werden.
</p>
<script src="/script/blowfish.js"></script>

<script>
function generate(form)
{
	var possible = "";
	var checked = 0;
	
	var quantity = form.quantity.value;
	
	if($('#uppercase').is(':checked'))
	{
		possible += "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
		checked++
		
	}
	
	if($('#lowercase').is(':checked'))
	{
		possible += "abcdefghijklmnopqrstuvwxyz"
		checked++
	}
	
	if($('#numbers').is(':checked'))
	{
		possible += "1234567890"
		checked++
	}
	
	if($('#brackets').is(':checked'))
	{
		possible += "!()[]{}"
		checked++
	}
	
	if($('#special').is(':checked'))
	{
		possible += "!#$%&*+,-.?@_~"
		checked++
	}
	
	if(quantity <= 0 || isNaN(quantity))
	{
		throwError();
	}
	
	hideWarning("#alert-data");

	generateKey(possible, quantity);
}

function generateKey(possible, length)
{
	
	var text = "";
	

    for( var i=0; i < length; i++ )
	{
		text += possible.charAt(Math.floor(Math.random() * possible.length));
	}

	showResult(text, "#password", "#password-text");
	
}
 </script>

<form>
		<input class="chars" type="checkbox" id="uppercase" name="uppercase" checked> Grosse Buchstaben (ABC...)<br>
		<input class="chars" type="checkbox" id="lowercase" name="lowercase" checked> Kleine Buchstaben (abc...)<br>
		<input class="chars" type="checkbox" id="numbers" name="numbers" checked> Zahlen (123...)<br>
		<input class="chars" type="checkbox" id="brackets" name="brackets"> Klammern<br>
		<input class="chars" type="checkbox" id="special" name="special"> Speziell (&amp;, $, !, %, ...)<br>
		<? dr_print_input("Anzahl Zeichen", "", "", "quantity", "number", "12", "", $required="required") ?> 
		<p><button type="button" class="btn btn-primary" onClick="generate(this.form)">Passwort generieren</button></p>
</form>
<? dr_print_success("Passwort:", "", "password", "password-text"); ?>
<? dr_print_notvalid("", "hidden"); ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>