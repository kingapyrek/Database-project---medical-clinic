<?php

	session_start();
	 include('../connect.php');

	 $id = $_GET['id'];
	 $nazwa = $_POST['nazwa'];
	 $miasto = $_POST['miasto'];
	 $ulica = $_POST['ulica'];
	 $numer = $_POST['numer'];
	 $kod = $_POST['kod'];


	 $result = pg_query_params($dbconn, 'SELECT * FROM placowka WHERE id_placowka = $1', array($id)) or die('Query failed: ' . pg_last_error());;

     $row = pg_fetch_assoc($result);

	 $query = pg_query_params($dbconn, 'UPDATE placowka SET nazwa=$1 WHERE id_placowka=$2', array($nazwa, $id)) or die('Query failed: ' . pg_last_error());;

	 $query2 = pg_query_params($dbconn, 'UPDATE adres SET miasto=$1, ulica=$2, numer=$3, kod_pocztowy=$4 WHERE id_adres=$5', array($miasto, $ulica, $numer, $kod, $row['id_adres'])) or die('Query failed: ' . pg_last_error());;

	 header('Location: pokaz_placowka.php');
?>