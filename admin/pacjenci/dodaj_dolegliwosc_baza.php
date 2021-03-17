<?php
    session_start();
	include('../connect.php');

	$id_pacjent = $_GET['id'];
	$nazwa = $_POST['nazwa'];
	$opis = $_POST['opis'];
	
    $latest_spec = pg_query($dbconn, 'SELECT * FROM specjalizacja ORDER BY id_specjalizacja DESC LIMIT 1') or die('Query failed: ' . pg_last_error());;
    $insert = pg_query_params($dbconn, 'INSERT INTO dolegliwosc(nazwa, opis) VALUES ($1, $2) RETURNING id_dolegliwosc', array($nazwa, $opis) ) or die('Query failed: ' . pg_last_error());;
    //uzyskanie id wlasnie utworzonego lekarza
    $row = pg_fetch_row($insert);
    $sql = 'SELECT FROM dodaj_pacjent_dolegliwosc($1,$2)';
    $res = pg_prepare($dbconn, "my_query", $sql);
    $res = pg_execute($dbconn, "my_query", array($id_pacjent, $row['0'])) or die('Query failed: ' . pg_last_error());;

	header('Location: pacjent_profil_admin.php?id=' . $id_pacjent);





?>