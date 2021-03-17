<?php
	session_start();
	include('../connect.php');

	$budynek = $_POST['budynek'];
	$pietro = $_POST['pietro'];
	$typ = $_POST['typ'];
	$placowka = $_POST['placowka'];

	$result = pg_query_params($dbconn, 'INSERT INTO poradnia(id_placowka, budynek, pietro, id_typ) VALUES ($1, $2, $3, $4)', array($placowka, $budynek, $pietro, $typ)) or die('Query failed: ' . pg_last_error());;

	 $redirect = pg_query_params($dbconn, 'SELECT * FROM placowka WHERE id_placowka=$1', array($placowka)) or die('Query failed: ' . pg_last_error());;
	 $row = pg_fetch_assoc($redirect);

	 header('Location: pokaz_poradnia_baza.php' . '?test=' . $row['id_placowka'] . '|' . $row['nazwa'] );





?>