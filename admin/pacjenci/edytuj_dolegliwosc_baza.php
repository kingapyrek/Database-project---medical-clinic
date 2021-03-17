<?php
	 session_start();
	 include('../connect.php');

	 $id =explode("|", $_GET['id']);
	 $nazwa = $_POST['nazwa'];
     $opis = $_POST['opis'];

     $query = pg_query_params($dbconn, 'UPDATE dolegliwosc SET nazwa=$1, opis=$2 WHERE id_dolegliwosc=$3', array($nazwa, $opis, $id[1])) or die('Query failed: ' . pg_last_error());;

	 header('Location: pacjent_profil_admin.php?id='. $id[0]);
?>