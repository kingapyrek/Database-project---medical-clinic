<?php
    include('../connect.php');
    session_start();
    $dzien =  date("Y-m-d", strtotime($_POST['dzien']));
    $pocz = $_POST['poczatek'];
    $koniec = $_POST['koniec'];
    $gabinet = $_POST['gabinet'];

    $result = pg_query_params($dbconn, 'INSERT INTO dyzur(id_lekarz, dzien, poczatek, koniec, id_gabinet) VALUES ($1, $2, $3, $4, $5)', array($_SESSION['id_lekarz'], $dzien, $pocz, $koniec, $gabinet)) or die('Query failed: ' . pg_last_error());;

    header('Location: wyswietl_lekarze_poradnia.php?id=' . $_SESSION['id_poradnia']);
?>