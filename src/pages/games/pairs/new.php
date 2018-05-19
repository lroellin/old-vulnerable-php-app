<?php $title = "Gedächtnisspiel" ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<p>Neues Spiel wird gestartet...</p>
<?
$cards = array(1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8);
shuffle($cards);

$_SESSION["games_pairs_started"] = true;
$_SESSION["games_pairs_cards"] = $cards;
$_SESSION["games_pairs_index_used"] = array();
$_SESSION["games_pairs_cardnumber_used"] = array();
$_SESSION["games_pairs_cards_open"] = array();
$_SESSION["games_pairs_player1_cards_open"] = array();
$_SESSION["games_pairs_player2_cards_open"] = array();
$_SESSION["games_pairs_tries"] = 0;
$_SESSION["games_pairs_gamecounter"] = 0;
$_SESSION["games_pairs_playernumber"] = 1;
$_SESSION["games_pairs_time_start"] = time();

dr_redirect("play", 1000);
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>