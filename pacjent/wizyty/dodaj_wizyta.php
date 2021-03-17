<?php
    session_start();
    include('../../connect.php');
    $godzina = $_GET['czas'];
    
    $query = pg_query_params($dbconn, 'INSERT INTO wizyta(godzina, data, id_pacjent, id_dyzur) VALUES($1, $2, $3, $4)', array($godzina, $_SESSION['dzien'], $_SESSION['id_pacjent'], (int)$_SESSION['id_dyzur'])) or die('Query failed: ' . pg_last_error());;

    echo "<script>
    alert('Dodano wizytę!');
    window.location.href='wyswietl_wizyty.php';
    </script>";


?>