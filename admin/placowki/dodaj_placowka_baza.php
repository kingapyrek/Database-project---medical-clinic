<?php
	session_start();
	include('../connect.php');

	$nazwa = $_POST['nazwa'];
	$miasto = $_POST['miasto'];
	$ulica = $_POST['ulica'];
	$numer = $_POST['numer'];
	$kod = $_POST['kod'];

	$query_adres = pg_query_params($dbconn, 'INSERT INTO adres(miasto, ulica, numer, kod_pocztowy) VALUES ($1, $2, $3, $4)', array($miasto, $ulica, $numer, $kod )) or die('Query failed: ' . pg_last_error());;
	
	$latest_adres = pg_query($dbconn, 'SELECT * FROM adres ORDER BY id_adres DESC LIMIT 1') or die('Query failed: ' . pg_last_error());;

	 $row = pg_fetch_assoc($latest_adres);
	 echo $row['id_adres'];

	
	$insert = pg_query_params($dbconn, 'INSERT INTO placowka(nazwa, id_adres) VALUES ($1, $2)', array($nazwa, $row['id_adres'] )) or die('Query failed: ' . pg_last_error());;

	header('Location: pokaz_placowka.php');

?>