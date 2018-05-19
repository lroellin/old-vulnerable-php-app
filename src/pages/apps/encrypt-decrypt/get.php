<?php $title = "Ver- & Entschlüsselung" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>
	Ver- und entschlüsselt Eingaben via Blowfish. Es wird nichts übertragen, sondern alles auf dem Gerät selber berechnet.<br>
	Trotzdem übernehme ich keine Verantwortung für Eingaben, aber jeder sollte selber wissen was er hier eingibt <i class="fa fa-smile-o"></i>
</p>
<script src="/script/blowfish.js"></script>

<script>
function encrypt(form)
{
	// Read form
	cleartext = form.txt_clear.value;
	key = form.txt_passphrase.value;
	
	if(validateKey(key))
	{
		hideWarning("#alert-data");
	}
	else
	{
		throwError();
	}
	
	var bf = new Blowfish(key);
	
	var ciphertext = bf.encrypt(cleartext);

	// Set result
	$txt_crypt = $(txt_crypt);
	$txt_crypt.val(ciphertext);
}

function decrypt(form)
{
	// Read form
	crypt = form.txt_crypt.value;
	key = form.txt_passphrase.value;
	
	if(validateKey(key))
	{
		hideWarning("#alert-data");
	}
	else
	{
		throwError();
	}
	
	var bf = new Blowfish(key);
	
	var plaintext = bf.decrypt(crypt);

	// Set result
	$txt_clear = $(txt_clear);
	$txt_clear.val(plaintext);
}

function validateKey(key)
{
	var result = false;
	if(
		key.length > 0
		&&
		key.length <= 56
	)
	{
		result = key;
	}
	
	return result
}

function generateKey()
{
	// Get ID
	$spinner = jQuery('#icon-refresh-key');
	$input = jQuery('#txt_passphrase');
	
	// Let it spin!
	$spinner.addClass('fa-spin');
	
	var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 56; i++ )
	{
		text += possible.charAt(Math.floor(Math.random() * possible.length));
	}
	
	$input.val(text)
	
	// End of fun
	$spinner.removeClass('fa-spin');
	
	// Update count
	countChars();
}

function countChars()
{
	 $field = jQuery('#txt_passphrase');
	 $text = jQuery('#displayCC');
	 
	 var length = $field.val().length;
	 
	 length = 56 - length;
	 
	 $text.text(length);
}

 </script>
<?php
	$key = third_getRandomString(56);
?>

<form>
	<textarea name="txt_clear" id="txt_clear" class="form-control" placeholder="Klartext"></textarea>
	<br>
	<p><button type="button" class="btn btn-primary pull-right" onClick="decrypt(this.form)"><i class="fa fa-unlock-alt"></i> Entschlüsseln <i class="fa fa-arrow-up"></i></button></p>
	<br>
	<br>
	<div class="input-group">
		<input name='txt_passphrase' id='txt_passphrase' class='form-control' type='text' placeholder='' value='' onkeyup="countChars()" required>
		<span class="input-group-addon" id="displayCC">56</span>
		<span class="input-group-btn">
			<button class="btn btn-default" type="button" onClick="generateKey()"><i id="icon-refresh-key" class="fa fa-refresh"></i></button>
		</span>
	</div>
	<p class='help-block'>Schlüssel <strong>unbedingt</strong> sicher aufbewahren, max. 56 Zeichen</p>
	<p><button type="button" class="btn btn-primary pull-left" onClick="encrypt(this.form)"><i class="fa fa-arrow-down"></i> Verschlüsseln <i class="fa fa-lock"></i></button></p>
	<br>
	<br>
	<textarea name="txt_crypt" id="txt_crypt" class="form-control" placeholder="Geheimtext"></textarea>
</form>
<? dr_print_notvalid("Die Schlüssellänge beträgt maximal 56 Zeichen.", "hidden"); ?>
<h1>FAQ</h1>
<p>
	Welcher Algorithmus wird verwendet?<br>
	Blowfish.
</p>
<p>
	Hilfe, ich habe den Schlüssel verloren. Kannst du mir ihn schicken?<br>
	Nein, ohne Schlüssel kann nichts zurück berechnet werden (ohne ausprobieren), es sind keine Hintertüren eingebaut.
</p>
<p>
	Aber ich gebe dir Geld!<br>
	Auch für Geld kann ich nichts machen, Kryptografie ist unbestechlich.
</p>
<p>
	Und wenn ich dir 50 Mio. gebe?<br>
	<i class="fa fa-meh-o"></i>
</p>
<hr>
Code von <a href="//github.com/drench/blowfish.js/blob/marcelgreter/blowfish.js" target="github">blowfish.js</a>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>