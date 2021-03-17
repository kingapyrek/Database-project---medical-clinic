<?php
	session_start();
	include('../connect.php');

	$nazwa = $_POST['nazwa'];
	$opis = $_POST['opis'];
	
	$insert = pg_query_params($dbconn, 'INSERT INTO poradnia_typ(nazwa, opis) VALUES ($1, $2)', array($nazwa, $opis )) or die('Query failed: ' . pg_last_error());;

	header('Location: pokaz_typy_poradni.php');

?>