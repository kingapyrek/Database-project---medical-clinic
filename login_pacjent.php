<?php
	
	include('connect.php');

	$login = $_POST['login'];
	$haslo =$_POST['password'];
	$result = pg_query_params($dbconn, 'SELECT * FROM pacjent WHERE login = $1 AND haslo=$2', array($login, md5($haslo))) or die('Query failed: ' . pg_last_error());;
	$row = pg_fetch_assoc($result);

	if(pg_num_rows($result)==1)
	{
		session_start();
		$_SESSION['login'] = $login;
		$_SESSION['id_pacjent'] = $row['id_pacjent'];
		$_SESSION['role'] = 'pacjent';
		header('Location: pacjent/panel_pacjent.php'); 
		
	}
	else if(pg_num_rows($result)==0)
	{
		include('zaloguj_pacjent.php');
		echo '<script language="javascript">';
		echo 'document.getElementById("info").innerHTML = \'Nie ma użytkownika o takich danych\n Sprawdź hasło oraz login\'';
		echo '</script>';

	}

?>