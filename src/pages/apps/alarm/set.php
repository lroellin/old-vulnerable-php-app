<?php $title = "Wecker" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>Ein Wecker, der bei Erreichen der Zeit eine Melodie spielt (oh really?).</p>

<!-- Site-specific because it is only needed here, would wake the CPU on every page every second otherwise -->
<script>
window.setTimeout("updateTime()", 0);// start immediately
window.setInterval("updateTime()", 1000);// update every second

var timecheck = "";
var snd = new Audio('/media/sound/Hassium.mp3');
function updateTime() {
	// Get time
	time = new Date().toTimeString().substring(0,8);
	tz = new Date().toTimeString().substring(9);
	
	// Set time on display
    document.getElementById("alarm-clock").firstChild.nodeValue = time;
	document.getElementById("alarm-info").firstChild.nodeValue = tz;
	
	// Play sound when reached
	if(time == timecheck)
	{	
		// Play sound
		snd.loop = true;
		snd.play();
		
		// Show button
		$stoptext = $('#alarm-stop');
		$stoptext.show();
	}

}

function readForm(form) {
	// Read form
	hour = form.hour.value;
	minute = form.minute.value;
	second = "00";
	
	time = hour + ":" + minute + ":" + second;
	setAlarm(time);
}

function readDelta(minutes) {
	now = new Date();
	then = new Date();
	then.setTime(now.getTime() + (minutes * 60 * 1000));
	
	then = then.toTimeString().substring(0,8);
	
	setAlarm(then);
}

function setAlarm(time) {
	// Disable form
	$(".disable").attr("disabled", "disabled");

	// Read time as variable
	timecheck = time;
	
	showResult(timecheck, "#alarm-time", "#alarm-text");
}


function stopAlarm() {
	// Stop audio
	snd.pause();
	// Change button
	$stopbutton = $('#alarm-stop-button');
	$stopbutton.addClass('btn-success');
	
	$stopbutton.text("Gestoppt");
}

function checkSound()
{
	// Play sound
	snd.loop = true;
	snd.play();
	
	// Show button
	$checkbutton = $('#soundcheck-button');
	$checkbutton.text("Soundcheck stoppen");
	$checkbutton.click(checkSoundStop);
}

function checkSoundStop()
{
	// Stop audio
	snd.pause();
}
</script>

<!-- Display -->
<p id="alarm-clock" class="text-center clock clock-display">00:00:00</p>
<p id="alarm-info" class="text-center clock">Fritz</p>

<h1>Wecker stellen</h1>
<p>Nach Uhrzeit:</p>
<form>
	<select name="hour" class="disable" size="1">
		<?php
			for($i = 0; $i <= 23; $i++)
			{
				// Format number
				$number = str_pad($i, 2, "0", STR_PAD_LEFT);
				print "<option value='$number'>$number</option>";
			}
		?>
	</select>
	:
	<select name="minute" class="disable" size="1">
		<?php
			for($i = 0; $i <= 59; $i++)
			{
				// Format number
				$number = str_pad($i, 2, "0", STR_PAD_LEFT);
				print "<option value='$number'>$number</option>";
			}
		?>
	</select>
	&nbsp;
	<button type="button" class="btn btn-primary disable" onClick="readForm(this.form)">Stellen</button><br>
</form>
<p><strong>oder</strong><br>nach Minuten:</p>
<?php
	$deltazeiten = array("10", "15", "30", "60");
	foreach($deltazeiten as $deltazeit)
	{
		print "<button type='button' class='btn btn-default disable' onClick='readDelta({$deltazeit})'>{$deltazeit} Min</button>";
	}
?>

<div class="alert alert-success" id="alarm-text" hidden>
	Wecker auf <span id="alarm-time">00:00:00</span> gesetzt<br>
	<a href="./" class="btn btn-default">Neu stellen</a>
</div>
<p id="alarm-stop" hidden>
	<button type="button" class="btn btn-danger" onClick="stopAlarm()" id="alarm-stop-button">Stoppen</button>
</p>

<h1>Troubleshooting</h1>
<p>
	<button type="button" class="btn btn-default" onClick="checkSound();" id="soundcheck-button">Soundcheck</button>
</p>
Sorg dafür, dass dein PC nicht in den Standby geht - diese Web-App kann ihn leider nicht aufwecken.</i><br>
Er funktioniert auch bei Zeitumstellungen, klingelt aber, im Falle von Sommer- auf Winterzeit, entsprechend zweimal.<br>
Leider funktioniert er derzeit auf mobilen Geräten nicht.

<hr>
<p>
	Idee von <a href="http://onlineclock.net">Online Alarm Clock</a><br>
	Basis-Code von <a href="http://www.primitivetype.com/resources/js_clock.php">PrimitiveType</a><br>
	Schrift von <a href="http://www.styleseven.com/">Style-7</a><br>
	Sound von <a href="http://source.android.com/">Android Open Source Project</a>
</p>

<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>