<?php
	 include('../connect.php');

	 $id = $_GET['id'];
	 $nazwa = $_POST['nazwa'];
	 $uczelnia = $_POST['uczelnia'];
	 $rok = $_POST['rok'];


	 $query = pg_query_params($dbconn, 'UPDATE specjalizacja SET nazwa=$1, uczelnia=$2, rok_otrzymania=$3 WHERE id_specjalizacja=$4', array($nazwa, $uczelnia, $rok, $id)) or die('Query failed: ' . pg_last_error());;

	 header('Location: lekarz_profil_admin.php?id='. $id);
?>