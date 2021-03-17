<?php
	session_start();
	include('../connect.php');

	$id = explode("|", $_GET['id']);

	$delete = pg_query_params($dbconn, 'DELETE FROM dolegliwosc WHERE id_dolegliwosc = $1', array($id[1])) or die('Query failed: ' . pg_last_error());;

	header('Location: pacjent_profil_admin.php?id=' . $id[0]);



?>