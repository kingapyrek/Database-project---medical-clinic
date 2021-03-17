<?php 

    session_start();
    unset($_SESSION['id_recepta']);

    echo "<script>";
    echo 'alert(\'Dodano e-receptę!\')';
    echo "window.location.href=\'profil_pacjent.php?id=" . $_SESSION['id_pacjent'] . "\';";
    echo "</script>";

   header('Location: profil_pacjent.php?id='. $_SESSION['id_pacjent']);


?>