<?php

	session_start();
	 include('../connect.php');

	 //$id_poradnia = $_GET['id'];
	  $id = explode('|', $_GET['id']);
	 $budynek = $_POST['budynek'];
	 $pietro = $_POST['pietro'];
	 $typ = $_POST['typ'];
	// echo $typ;


	 $result = pg_query_params($dbconn, 'SELECT * FROM placowka WHERE id_placowka = $1', array($id[1])) or die('Query failed: ' . pg_last_error());;

     $row = pg_fetch_assoc($result);

	 $query = pg_query_params($dbconn, 'UPDATE poradnia SET budynek=$1, pietro=$2, id_typ=$3 WHERE id_poradnia=$4', array($budynek, $pietro, $typ, $id[0])) or die('Query failed: ' . pg_last_error());;

	 //$query2 = pg_query_params($dbconn, 'UPDATE adres SET miasto=$1, ulica=$2, numer=$3, kod_pocztowy=$4 WHERE id_adres=$5', array($miasto, $ulica, $numer, $kod, $row['id_adres'])) or die('Query failed: ' . pg_last_error());;


	 header('Location: pokaz_poradnia_baza.php' . '?test=' . $row['id_placowka'] . '|' . $row['nazwa'] );

?>