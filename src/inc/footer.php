<!-- Footer -->
<hr />

<div class="panel-group" id="accordionFooter">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionFooter" href="#collapseFortune">
			Zufälliger Glückskeks-Spruch
			</a>
			</h3>
		</div>
		<div id="collapseFortune" class="panel-collapse collapse">
			<div class="panel-body">
				<?php
				// Get a fortune
				exec('/usr/games/fortune', $fortune);
				// Print it line by line to prevent HTML-merging of spaces
				foreach($fortune as $line)
				print "$line<br>";
				?>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionFooter" href="#collapseStats">
			Infos & Tools für Nerds
			</a>
			</h3>
		</div>
		<div id="collapseStats" class="panel-collapse collapse">
			<div class="panel-body">
				<?php
				$time = date("H:i:s",time());
				$date = date("d.m.Y",time());
				$memoryusage = round(memory_get_peak_usage() / 1024, 3);
				$endtime = microtime(true);
				$calctime = round(($endtime - $starttime),5);
				echo "<table class='table table-striped'>";
					echo "<tr>";
						echo "<td>Serverzeit</td>";
						echo "<td>$time Uhr am $date</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Speichernutzung</td>";
						echo "<td>$memoryusage KB</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Laufzeit</td>";
						echo "<td>{$calctime}s</td>";
					echo "</tr>";
				echo "</table>";
				?>
				<a href='http://validator.w3.org/check?uri=<? echo "{$URI}"; ?>' target='w3c' class="btn btn-default"><i class="fa fa-html5"></i> W3C Validator</a>
			</div>
		</div>
	</div>
</div>
<!-- Body -->
