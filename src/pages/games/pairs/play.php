<?php $title = "Gedächtnisspiel" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>
	Lokale Zweispieler-Version des bekannten Gedächtnisspiels. Die Regeln sollten klar sein <i class="fa fa-smile-o"></i><br>
	Der bekanntere, englische Name für dieses Spiel ist leider markenrechtlich geschützt.
</p>
<?php
$dir = "/media/img/games/pairs/";

$card_opened = false;

if($_SESSION['games_pairs_started'])
{
	// Success/Fail management
	if(isset($_POST['lu_index']))
	{
		// Get clicked card
		$lu_cardnumber 	= $_SESSION['games_pairs_cards'][$_POST['lu_index']];
		
		// If this card is already in the arrays of clicked ones, open it permanently, unless the same card has been clicked twice.
		if((in_array($lu_cardnumber, $_SESSION['games_pairs_cardnumber_used'])) AND (!(in_array($_POST['lu_index'], $_SESSION['games_pairs_index_used']))))
		{
			$card_opened = true;
			// Global
			array_push($_SESSION['games_pairs_cards_open'], $lu_cardnumber);
			// Per Player
			switch($_SESSION['games_pairs_playernumber'])
			{
				case 1:
				array_push($_SESSION['games_pairs_player1_cards_open'], $lu_cardnumber); break;
				case 2:
				array_push($_SESSION['games_pairs_player2_cards_open'], $lu_cardnumber); break;
			}
			
		}
		
		// Push clicked card index to array
		array_push($_SESSION['games_pairs_index_used'], $_POST['lu_index']);
		// Push clicked card number to array
		array_push($_SESSION['games_pairs_cardnumber_used'], $lu_cardnumber);
	}

	// Let's make a copy of SESSION, so we can use it later to print the view
	$view_copy = $_SESSION;

	// Round management
	if(isset($_POST['lu_index']))
	{
		
		// 0 on the first, 1 on the second try
		if($_SESSION['games_pairs_tries'] == 1)
		{
			// Reset after second
			$_SESSION['games_pairs_tries'] = 0;
			$_SESSION['games_pairs_index_used'] = array();
			$_SESSION['games_pairs_cardnumber_used'] = array();
			
			// If the player has opened no new cards, change player
			if(!$card_opened)
			{
				switch($_SESSION['games_pairs_playernumber'])
				{
					case 1:
					$_SESSION['games_pairs_playernumber'] = 2; break;
					case 2:
					$_SESSION['games_pairs_playernumber'] = 1; break;
				}
			}
		}	
		
		// Increase tries
		else
		{
			$_SESSION['games_pairs_tries']++;
			
		}
		
		// Moves
		$_SESSION['games_pairs_gamecounter']++;
	}

	// Stats
	if(isset($_POST['lu_index']))
	{
		// Have all cards been opened?
		if(sizeof($_SESSION['games_pairs_cards_open']) >= 8)
		{
			$time_end = time();
			$time = $time_end - $_SESSION['games_pairs_time_start'];
			echo "<div class='alert alert-success'><strong>Alle Karten aufgedeckt!</strong> In $time Sekunden/{$_SESSION['games_pairs_gamecounter']} Zügen</div>";		
		}
		
		// Gather pairs
		$player1_number = sizeof($_SESSION['games_pairs_player1_cards_open']);
		$player2_number = sizeof($_SESSION['games_pairs_player2_cards_open']);
	}

	// Ok, information is gathered, let's print the cards and information
	// Player
	echo "<table class='table' id='top'>";
		echo "<thead>";
			echo "<tr>";
				echo "<th class='text-left ";
					echo ($_SESSION['games_pairs_playernumber'] == 1 ? 'info' : '');
				echo "'><h2>Spieler 1<h2></th>";
				echo "<th class='text-right ";
					echo ($_SESSION['games_pairs_playernumber'] == 2 ? 'info' : '');
				echo "'><h2>Spieler 2<h2></th>";
			echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
			echo "<tr>";
				echo "<td class='text-left'>$player1_number Paar(e)</td>";
				echo "<td class='text-right'>$player2_number Paar(e)</thd";
			echo "</tr>";
		echo "</tbody>";
	echo "</table>";

	// Play board
	echo "<form method='post' action='play#top'>";
	echo "<div class='row'>";
	foreach ($view_copy['games_pairs_cards'] as $index => $card)
	{
		// New row after 4 cards
		if ($index%4 == 0)
		{
			echo "</div><div class='row'>";
		}
		
		echo "<div class='col-xs-3'>";
			// Both cards have been opened
			if(in_array($card, $view_copy['games_pairs_cards_open']))
			{
				echo "<button class='btn btn-success' disabled='disabled'><img src='$dir/card{$card}.png' class='img-responsive' /></button>";
			}
			// Zero or one card has been opened
			else
			{
				// One card has been opened
				// Show last clicked one temporarily, but leave it activated (for the next player to click)
				if(in_array($index, $view_copy['games_pairs_index_used']))
				{
					echo "<button class='btn btn-primary' name='lu_index' value='$index' type='submit'><img src='$dir/card{$card}.png' class='img-responsive' /></button>";
				}
				
				// Zero cards have been opened
				// Leave it covered
				else
				{
					echo "<button class='btn btn-default' name='lu_index' value='$index' type='submit'><img src='$dir/card0.png' class='img-responsive'/></button>";
				}
			}
		echo "</div>";
	}
	echo "</div>";
	echo "</form>";
}
?>
<br>
<p><a href='new' class='btn btn-default'>Neustart</a></p>
<hr>
Symbole von <a href="http://fortawesome.github.io/Font-Awesome/" target="fontawesome">FontAwesome</a><br>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>