<?php
    session_start();
    if($_SESSION['role'] == 'pacjent')
    {
        $_SESSION['id_dyzur']= $_GET['id'];
?>
<!doctype html>
<html lang="pl">
    <head>
        <?php include('../head.php'); ?>
        <link rel="stylesheet" type="text/css" href="../pacjent.css">
        <title>Wybierz godzinę</title>
        <style>
            ul
            {
                list-style-type: none;
                padding-left: 0;
            }
            i
            {
                padding-right: 10px;
            }

        </style>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <?php
            include('../../connect.php');
            $query = pg_query_params($dbconn, 'SELECT * from lekarz_dyzury WHERE id_dyzur=$1;', array((int)$_SESSION['id_dyzur'])) or die('Query failed: ' . pg_last_error());;

            $row = pg_fetch_assoc($query);
            $_SESSION['dzien'] = $row['dzien'];
        ?>

        <div class="container">
            <div class="row p-3">  
                <div class="col-md-12 text-center bg-light"  style="border-radius:10px;">
                    <?php include('menu.php') ?>
                </div>
            </div>
            <div class="row p-3 min-vh-100"> 
                <div class="col-md-12 p-3 text-center" id="content">
                    <div class="col-md-6 mx-auto">
                        <h2 style="font-weight: bold;padding: 10px;"> Dostępne godziny </h2>
                        <form role="form" method="get" action="dodaj_wizyta.php" id="form1">
                            <select class="form-select" aria-label="Default select example" name="czas" style="margin: 10px; padding: 5px;" required>
                            <?php
                            echo "ok";
                                $start = strtotime($row['poczatek']);
                                $end   = strtotime($row['koniec']);
                                $result = pg_query_params($dbconn, 'SELECT * from wizyta WHERE id_dyzur=$1;', array((int)$_SESSION['id_dyzur'])) or die('Query failed: ' . pg_last_error());;
                                //$arr = pg_fetch_all($result);
                                $num = pg_num_rows($result);
                                $godziny = array();

                                while($row = pg_fetch_assoc($result))
                                {
                                    array_push($godziny,date('H:i', strtotime($row['godzina'])));
                                }
                                
                               

                                for ($i=$start; $i<=$end-30; $i = $i + 30*60)
                                {
                                    $flag = 0;
                                    foreach( $godziny as $godzina)
                                    {
                                        if($godzina == date('H:i',$i))
                                        {
                                        //echo $godzina;
                                            $flag = 1;
                                        }
                                    }
                                    
                                    if($flag == 0)
                                    {
                                       echo '<option>'.date('H:i',$i).'</option>';
                                    }
                                }
                            ?>
                            </select>
                        
                        <br><br><br>
                        <?php 
                            $wizyta = pg_query_params($dbconn, 'SELECT * from wybor_wizyta WHERE id_dyzur=$1;', array((int)$_SESSION['id_dyzur'])) or die('Query failed: ' . pg_last_error());;
                            $wizyta_row = pg_fetch_assoc($wizyta);

                        ?>
                       <h3 style="font-weight: bold;padding: 10px;"> Szczegóły wizyty </h3>
                        <div class="card m-3">
                            <h5 class="card-header">Wizyta</h5>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['imie'] . " " . $row['nazwisko'] ?></h5>
                                <p class="card-text">
                                    <ul>
                                        <li><i class="fas fa-calendar-alt"></i><?php echo $wizyta_row['dzien'] ?> </li>
                                        <li><i class="fas fa-map-marker-alt"></i><?php echo $wizyta_row['miasto'] . " " . $wizyta_row['ulica'] . " " . $wizyta_row['adres_numer'] ?> </li>
                                        <li><i class="fas fa-hospital"></i><?php echo $wizyta_row['placowka_nazwa'] ." poradnia " . $wizyta_row['poradnia_nazwa'] . " budynek " . $wizyta_row['budynek'] . " piętro " . $wizyta_row['pietro'] . " gabinet " . $wizyta_row['numer_gabinet']?></li>     
                                    </ul>
                                </p>
                            </div>
                        </div>
                    </form>
                    <button type="submit" form="form1" class="btn btn-success btn-lg"><i class="far fa-check-square"></i>Zatwierdź</button>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php }else{
	header('Location: ../brak_uprawnien.php');} ?>