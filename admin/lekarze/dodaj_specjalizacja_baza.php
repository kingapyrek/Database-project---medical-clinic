<?php
	include('../connect.php');

	$id_lekarz = $_GET['id'];
	$nazwa = $_POST['nazwa'];
	$uczelnia = $_POST['uczelnia'];
	$rok = $_POST['rok'];

	//$result = pg_query_params($dbconn, 'INSERT INTO specjalizacja(nazwa, uczelnia, rok_otrzymania) VALUES ($1, $2, $3)', array($nazwa, $uczelnia, $rok)) or die('Query failed: ' . pg_last_error());;
	
	$latest_spec = pg_query($dbconn, 'SELECT * FROM specjalizacja ORDER BY id_specjalizacja DESC LIMIT 1') or die('Query failed: ' . pg_last_error());;
	$temp = pg_fetch_assoc($latest_spec);
	$assoc = pg_query_params('INSERT INTO lekarz_specjalizacja(id_lekarz, id_specjalizacja) VALUES ($1, $2)', array($id_lekarz, $temp['id_specjalizacja']));
//	 $redirect = pg_query_params($dbconn, 'SELECT * FROM placowka WHERE id_placowka=$1', array($placowka)) or die('Query failed: ' . pg_last_error());;
//	 $row = pg_fetch_assoc($redirect);

	 header('Location: lekarz_profil_admin.php?id=' . $id_lekarz);





?>