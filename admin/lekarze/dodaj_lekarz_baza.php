<?php
    include('../connect.php');

    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $pesel = $_POST['pesel'];
    $tel = $_POST['tel'];
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $insert = pg_query_params($dbconn, 'INSERT INTO lekarz(imie, nazwisko, email, telefon, pesel, login, haslo) VALUES ($1, $2, $3, $4, $5, $6, $7) RETURNING id_lekarz', array($imie, $nazwisko, $email, $tel, $pesel, $login, md5($haslo) )) or die('Query failed: ' . pg_last_error());;
    //uzyskanie id wlasnie utworzonego lekarza
    $row = pg_fetch_row($insert);


	header('Location: lekarz_profil_admin.php?id=' . $row['0']);



?>