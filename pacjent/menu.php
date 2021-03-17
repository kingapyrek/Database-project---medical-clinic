<?php
    echo '<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#"><i class="fas fa-heartbeat fa-lg"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="panel_pacjent.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="profil.php">Twój profil</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Umów wizytę
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="wizyty/wybierz_placowka.php">Wybierz po placówkach</a>
            <a class="dropdown-item" href="wizyty/wyszukaj_lekarza.php">Wyszukaj lekarza</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="wizyty/wyswietl_wizyty.php">Twoje wizyty</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="recepty.php">Twoje e-recepty</a>
        </li>
        </ul>
    </div>
    <a href="../wylogowywanie_sesja.php"><div style="padding: 10px; display:inline-block;">Wyloguj</div><i class="fas fa-sign-out-alt fa-lg"></i></a>


</nav>'
?>