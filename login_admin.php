<?php //session_start();

	include('connect.php');

	$admin_login='admin';
	$admin_haslo='password123';


	$login = $_POST['login'];
	$haslo = md5($_POST['password']);

	if($login==$admin_login && $haslo==md5($admin_haslo))
	{
		//echo "ok!";
		session_start();
		$_SESSION["admin"]=$admin_login;
		$_SESSION['role'] = 'admin';
		header('Location: admin/panel_admina.php');
	}
	else if(pg_num_rows($result)==0)
	{
		include('zaloguj_admin.php');
		echo '<script language="javascript">';
		echo 'document.getElementById("info").innerHTML = \'Niepoprawne dane admina!<br> Sprawdź hasło oraz login\'';
		echo '</script>';

	}

?>


