<?php
	session_start();
	include('../connect.php');

	$id =  $_GET['id'];

    $delete = pg_query_params($dbconn, 'DELETE FROM lekarz WHERE id_lekarz = $1', array($id)) or die('Query failed: ' . pg_last_error());;
    
    echo "<script>
    alert('Zwolniono lekarza!');
    window.location.href='pokaz_wszystkich_lekarzy.php';
    </script>";


	//header('Location: pokaz_wszystkich_lekarzy.php' );



?>