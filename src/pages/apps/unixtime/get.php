<?php $title = "Unixzeit" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>Berechnet die Unixzeit zu einer bestimmten Zeit vor und zurück.</p>
<!-- Site-specific because it is only needed here, would wake the CPU on every page every second otherwise -->
<script>
window.setTimeout("updateTime()", 0);// start immediately
window.setInterval("updateTime()", 1000);// update every second
function updateTime() {
	// Get time
	time = new Date().getTime().toString().slice(0,-3);
	
	// Set time on display
    document.getElementById("unixtime-clock").firstChild.nodeValue = time;
}

function readUnixtime(form) {
	// Read form
	date = form.date.value
	time = form.time.value
	
	datestring = date + " " + time
	
	/*
	hour = form.hour.value;
	minute = form.minute.value;
	second = form.second.value;
	
	day = form.day.value;
	month = form.month.value;
	year = form.year.value;
	
	// Validation
	if(!($.isNumeric(year)))
	{
		throwError();
	}
	
	// Convert to datestring
	datestring = year + "-" + month + "-" + day + "T" + hour + ":" + minute + ":" + second + "Z";
	*/
	
	
	hideWarning();
	
	setUnixtime(datestring)
}

function setUnixtime(timenew) {
	var unixtime = Date.UTC(timenew)
	
	if(unixtime.length == 0)
	{
		throwError();
	}
	
	showResult(unixtime, "#unixtime", "#unixtime-text");
}

function readRealtime(form) {
	// Read form
	unixtimeinput = form.unixtime.value;
	
	// Validation
	if(!($.isNumeric(unixtimeinput)))
	{
		throwError();
	}
	
	
	hideWarning();
	
	setRealtime(unixtimeinput);
}

function setRealtime(unixtimeinput) {
	var realtime = new Date(unixtimeinput * 1000);
	
	hour = realtime.getUTCHours();
	hour = pad(hour.toString(), 2);
	minute = realtime.getUTCMinutes();
	minute = pad(minute.toString(), 2);
	second = realtime.getUTCSeconds();
	second = pad(second.toString(), 2);
	
	day = realtime.getUTCDate();
	month = realtime.getUTCMonth() + 1;
	year = realtime.getUTCFullYear();
	
	realtime_time = hour + ":" + minute + ":" + second;
	realtime_date = day + "." + month + "." + year;
	
	realtime_timedate = realtime_time + " " + "(" + realtime_date + ")"
	
	showResult(realtime_timedate, "#realtime", "#realtime-text");
}

</script>

<!-- Display -->
<p id="unixtime-clock" class="text-center clock clock-display">00:00:00</p>
<p id="unixtime-info" class="text-center clock">UTC</p>

<h1>Unixzeit berechnen</h1>
<form>
	<div class='form-group'>
		<?php
			$time = date("H:i:s",time());
			$date = date("Y-m-d",time());
		?>
		<label for='date' class='control-label'>Datum</label>
		<input name='date' id='date' class='form-control' type='date' placeholder='' required value='<? print $date; ?>'><p class='help-block'></p>
		<label for='time' class='control-label'>Zeit (lokale Zeitzone)</label>
		<input name='time' id='time' class='form-control' type='time' placeholder='' required value='<? print $time; ?>'><p class='help-block'></p>
	</div>
	<!-- 
	<select name="hour" size="1" class="timeselect">
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
	<select name="minute" size="1" class="timeselect">
		<?php
			for($i = 0; $i <= 59; $i++)
			{
				// Format number
				$number = str_pad($i, 2, "0", STR_PAD_LEFT);
				print "<option value='$number'>$number</option>";
			}
		?>
	</select>
	:
	<select name="second" size="1" class="timeselect">
		<?php
			for($i = 0; $i <= 59; $i++)
			{
				// Format number
				$number = str_pad($i, 2, "0", STR_PAD_LEFT);
				print "<option value='$number'>$number</option>";
			}
		?>
	</select>
	&nbsp; UTC
	<br>
	<select name="day" size="1" class="timeselect">
		<?php
			for($i = 1; $i <= 31; $i++)
			{
				// Format number
				$number = str_pad($i, 2, "0", STR_PAD_LEFT);
				print "<option value='$number'>$number</option>";
			}
		?>
	</select>
	&nbsp;
	<select name="month" size="1" class="timeselect">
		<?php
			for($i = 1; $i <= 12; $i++)
			{
				// Format number
				$number = str_pad($i, 2, "0", STR_PAD_LEFT);
				print "<option value='$number'>$number</option>";
			}
		?>
	</select>
	&nbsp;
	<input name="year" type="number" value="<? echo date("Y"); ?>" size="4" maxlength="4" required></input>
	-->
	<br><br>
	<button type="button" class="btn btn-primary" onClick="readUnixtime(this.form)">Berechnen</button><br>
</form>
<? dr_print_success("Ergibt", "Sekunden seit der Epoche", "unixtime", "unixtime-text"); ?>
<h1>Realzeit berechnen</h1>
<form>
	<? dr_print_input("Unixzeit", "", "", "unixtime", "number"); ?>
	<br>
	<button type="button" class="btn btn-primary" onClick="readRealtime(this.form)">Berechnen</button><br>
</form>
<? dr_print_success("Ergibt", "", "realtime", "realtime-text"); ?>
<? dr_print_notvalid("", "hidden"); ?>

<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>