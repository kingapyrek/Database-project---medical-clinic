<?php
    include('../connect.php');
    $id_poradnia = explode("|", $_GET['id']);
    $numer = $_POST['numer'];

    $result = pg_query_params($dbconn, 'INSERT INTO gabinet(numer, id_poradnia) VALUES ($1, $2)', array($numer, $id_poradnia[1])) or die('Query failed: ' . pg_last_error());;

    header('Location: pokaz_gabinety_poradnia.php?id=' . $_GET['id']);



?>