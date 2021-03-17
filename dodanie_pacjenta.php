<?php
	session_start();
	include('connect.php');

	$login = $_POST['login'];
	$haslo =$_POST['password'];
	$email = $_POST['email'];
	$imie = $_POST['imie'];
	$nazwisko = $_POST['nazwisko'];
	$data = date("Y-m-d", strtotime($_POST['data_ur']));
	$pesel = $_POST['pesel'];
	$miasto = $_POST['miasto'];
	$ulica = $_POST['ulica'];
	$numer = $_POST['numer'];
	$kod = $_POST['kod'];


	//if(!empty($login) && !empty($haslo) && !empty($email) && !empty($imie) && !empty($nazwisko) && !empty($data) && !empty($pesel) )
	//{

		$adres_sprawdz = pg_query_params($dbconn, 'SELECT * FROM adres WHERE miasto=$1 AND ulica=$2 AND numer=$3 AND kod_pocztowy=$4', array($miasto, $ulica, $numer, $kod)) or die('Query failed: ' . pg_last_error());

		if(pg_num_rows($adres_sprawdz)==0)
		{
			$adres = pg_query_params($dbconn, 'INSERT INTO adres(miasto, ulica, numer, kod_pocztowy) VALUES ($1, $2, $3, $4) RETURNING id_adres ', array($miasto, $ulica, $numer, $kod)) or die('Query failed: ' . pg_last_error());
			$adres_row = pg_fetch_assoc($adres);
		}
		else if(pg_num_rows($adres_sprawdz)==1)
		{
			$adres_row = pg_fetch_assoc($adres_sprawdz);
		}

		$result = pg_query_params($dbconn, 'INSERT INTO pacjent(imie, nazwisko, data_urodzenia, email, pesel, login, haslo, id_adres) VALUES ($1, $2, $3, $4, $5, $6, $7, $8);', array($imie, $nazwisko, $data, $email, $pesel, $login, md5($haslo), $adres_row['id_adres'])) or die('Query failed: ' . pg_last_error());
		if($result)
		{
		
		echo "<script>
    alert('Zarejestrowano użytkownika!');
    window.location.href='zaloguj_pacjent.php';
    </script>";
		}
		else
		{
			
			echo '<script language="javascript">';
			echo 'alert(\'blad\')';
			echo '</script>';
			//echo "<script>alert('$error');</script>";

		}
//}
/*	else
	{
		
		echo '<script language="javascript">';
		echo 'alert(\'Uzupełnij wszystkie dane!\')';
		echo '</script>';
		header('Location: rejestracja_pacjenta.php');
	}*/



?>