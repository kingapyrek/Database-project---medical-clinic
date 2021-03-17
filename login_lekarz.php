<?php
	
	include('connect.php');

	$login = $_POST['login'];
	$haslo =$_POST['password'];
	$result = pg_query_params($dbconn, 'SELECT * FROM lekarz WHERE login = $1 AND haslo=$2', array($login, md5($haslo))) or die('Query failed: ' . pg_last_error());;

	if(pg_num_rows($result)==1)
	{
		$row = pg_fetch_assoc($result);
		session_start();
		$_SESSION['id_lekarz'] = $row['id_lekarz'];
		$_SESSION['role'] = 'lekarz';
		header('Location: lekarz/panel_lekarz.php');

		
	}
	else if(pg_num_rows($result)==0)
	{
		include('zaloguj_lekarz.php');
		echo '<script language="javascript">';
		echo 'document.getElementById("info").innerHTML = \'Nie ma użytkownika o takich danych\n Sprawdź hasło oraz login\'';
		echo '</script>';

	}

?>