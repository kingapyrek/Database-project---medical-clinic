<?php
    session_start();
	 include('../connect.php');

	 $id = $_GET['id'];
	 $imie = $_POST['imie'];
     $nazwisko = $_POST['nazwisko'];
     $data = $_POST['data'];
	 $email = $_POST['email'];
	 $pesel = $_POST['pesel'];
     $miasto = $_POST['miasto'];
     $ulica = $_POST['ulica'];
     $numer = $_POST['numer'];
     $kod = $_POST['kod'];

	 $query = pg_query_params($dbconn, 'UPDATE pacjent SET imie=$1, nazwisko=$2, data_urodzenia=$3, email=$4, pesel=$5 WHERE id_pacjent=$6', array($imie, $nazwisko, $data, $email, $pesel, $id)) or die('Query failed: ' . pg_last_error());;
     $pacjent = pg_query_params($dbconn, 'SELECT * FROM pacjent WHERE id_pacjent=$1', array($id)) or die('Query failed: ' . pg_last_error());;
     $row = pg_fetch_assoc($pacjent);
     $query2 = pg_query_params($dbconn, 'UPDATE adres SET miasto=$1, ulica=$2, numer=$3, kod_pocztowy=$4 WHERE id_adres=$5', array($miasto, $ulica, $numer, $kod, $row['id_adres'])) or die('Query failed: ' . pg_last_error());;

	 header('Location: pacjent_profil_admin.php?id='. $id);
?>