<?php
    $id = explode('|', $_GET['id']);
    echo $id[0];

    include('../connect.php');

    $sql = 'SELECT FROM dodaj_lekarz_poradnia($1,$2)';
    $res = pg_prepare($dbconn, "my_query", $sql);
    $res = pg_execute($dbconn, "my_query", array($id[0], $id[2])) or die('Query failed: ' . pg_last_error());;
    
    header('Location: pokaz_lekarzy_poradnia.php?id='. $id[1] . "|" . $id[2]);




?>