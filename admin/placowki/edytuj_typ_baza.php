<?php
	session_start();
 	include('../connect.php');

	 $id = $_GET['id'];
	 $nazwa = $_POST['nazwa'];
	 $opis = $_POST['opis'];



	 $query = pg_query_params($dbconn, 'UPDATE poradnia_typ SET nazwa=$1, opis=$2 WHERE id_typ=$3 ', array($nazwa, $opis, $id)) or die('Query failed: ' . pg_last_error());;


	 header('Location: pokaz_typy_poradni.php');


?>