<?php


	 include('../connect.php');

	 $id = $_GET['id'];
	 $imie = $_POST['imie'];
	 $nazwisko = $_POST['nazwisko'];
	 $email = $_POST['email'];
	 $telefon = $_POST['tel'];
	 $pesel = $_POST['pesel'];


	 $query = pg_query_params($dbconn, 'UPDATE lekarz SET imie=$1, nazwisko=$2, email=$3, telefon=$4, pesel=$5 WHERE id_lekarz=$6', array($imie, $nazwisko, $email, $telefon, $pesel, $id)) or die('Query failed: ' . pg_last_error());;

	 header('Location: lekarz_profil_admin.php?id='. $id);
?>