<?php
    session_start();
	include('../connect.php');

	$id_pacjent = $_GET['id'];
	$nazwa = $_POST['nazwa'];
	$opis = $_POST['opis'];
	
    $insert = pg_query_params($dbconn, 'INSERT INTO dolegliwosc(nazwa, opis) VALUES ($1, $2) RETURNING id_dolegliwosc', array($nazwa, $opis) ) or die('Query failed: ' . pg_last_error());;
    
    $row = pg_fetch_row($insert);
    $sql = 'SELECT FROM dodaj_pacjent_dolegliwosc($1,$2)';
    $res = pg_prepare($dbconn, "my_query", $sql);
    $res = pg_execute($dbconn, "my_query", array($id_pacjent, $row['0'])) or die('Query failed: ' . pg_last_error());;

    echo "<script>
    alert('Dodano dolegliwość!');
   
    </script>";

	header('Location: profil_pacjent.php?id=' . $id_pacjent);





?>