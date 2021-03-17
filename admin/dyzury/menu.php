<?php
echo '        	<div class="nav-side-menu">
    <div class="brand">Menu</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
               <!-- <li>
                  <a href="#">
                  <i class="fa fa-dashboard fa-lg"></i> Dashboard
                  </a>
                </li>-->

                <li  data-toggle="collapse" data-target="#placowki" class="collapsed">
                  <a href="#"><i class="fa fa-clinic-medical fa-lg"></i> Placówki <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="placowki">
                    <li><a href="../placowki/pokaz_placowka.php">Wyświetl/edytuj placówki</a></li>
                    <li><a href="../placowki/dodaj_placowka.php">Dodaj placówkę</a></li>
                    <li><a href="../placowki/pokaz_poradnia.php">Wyświetl/edytuj/dodaj poradnie</a></li>
                    <li><a href="../placowki/pokaz_typy_poradni.php">Wyświetl/edytuj typy poradni</a></li>
                    <li><a href="../placowki/dodaj_typ.php">Dodaj typ poradni</a></li>
                </ul>


                <li data-toggle="collapse" data-target="#lekarze" class="collapsed">
                  <a href="#"><i class="fa fa-user-md fa-lg"></i> Lekarze <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse" id="lekarze">
                  <li><a href="../lekarze/pokaz_wszystkich_lekarzy.php">Wyświetl/edytuj wszystkich lekarzy</a></li>
                  <li><a href="../lekarze/wybierz_placowka.php">Wyświetl/edytuj/dodaj lekarzy w danej poradni</a></li>
                  <li><a href="../lekarze/dodaj_lekarz.php">Dodaj lekarza</a></li>
                </ul>


                <li data-toggle="collapse" data-target="#dyzury" class="collapsed">
                  <a href="#"><i class="fas fa-calendar-alt fa-lg"></i>Dyżury <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="dyzury">
                  <li><a href="wybierz_placowka_gabinet.php">Wyświetl/dodaj gabinety do poradni</a></li>
                  <li><a href="wybierz_placowka_dyzur.php">Dodaj dyżur </a></li>
                  <li><a href="statystyki.php">Statystyki </a></li>
                </ul>


                  <li data-toggle="collapse" data-target="#pacjenci" class="collapsed">
                  <a href="#"><i class="fas fa-user-injured fa-lg"></i> Pacjenci <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="pacjenci">
                  <li><a href="../pacjenci/wyswietl_pacjenci.php">Wyświetl/edytuj pacjentów</a></li>
                  <li><a href="../pacjenci/wyswietl_leki.php">Wyświetl leki</a></li>
                </ul>

                <li><a href="../../wylogowywanie_sesja.php">
                	<i class="fas fa-sign-out-alt fa-lg"></i>
                	<span>Wyloguj</span></a>
                </li>
            </ul>
     </div>
</div>';
?>