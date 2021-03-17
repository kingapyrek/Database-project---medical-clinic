<?php
    session_start();
    if($_SESSION['role'] == 'pacjent')
    {
?>
<!doctype html>
<html lang="pl">
    <head>
        <?php include('../head.php'); ?>
        <link rel="stylesheet" type="text/css" href="../pacjent.css">
        <title>Wizyty</title>
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
        <div class="container">
            <div class="row p-3">  
                <div class="col-md-12 text-center bg-light"  style="border-radius:10px;">
                    <?php include('menu.php') ?>
                </div>
            </div>
            <div class="row p-3 min-vh-100"> 
                <div class="col-md-12 p-3" id="content">
                    <div class="col-md-7 mx-auto">
                        <h2 style="font-weight: bold;padding: 10px; text-align:center;"> Twoje wizyty </h2>
                        <?php
                            include('../../connect.php');
                            $wizyty = pg_query_params($dbconn, 'SELECT * from pacjent_wizyty WHERE id_pacjent=$1 ORDER BY data, godzina;', array((int)$_SESSION['id_pacjent'])) or die('Query failed: ' . pg_last_error());;
                            while($row = pg_fetch_assoc($wizyty))
                            {

                        ?>
                        
                        <div class="card m-3">
                            <h5 class="card-header">Wizyta</h5>
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-user-md"></i><?php echo $row['imie'] . " " . $row['nazwisko'] ?></h5>
                                <p class="card-text">
                                    <ul>
                                        <li><i class="fas fa-calendar-alt"></i><?php echo $row['data']?> </li>
                                        <li><i class="far fa-clock"></i><?php echo date('H:i', strtotime($row['godzina'])) ?></li>
                                        <li><i class="fas fa-map-marker-alt"></i><?php echo $row['miasto'] . " " . $row['ulica'] . " " . $row['adres_numer'] ?> </li>
                                        <li><i class="fas fa-hospital"></i><?php echo $row['placowka_nazwa'] ." poradnia " . $row['poradnia_nazwa'] . " budynek " . $row['budynek'] . " piętro " . $row['pietro'] . " gabinet " . $row['numer_gabinet']?></li>     
                                    </ul>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php }else{
	header('Location: ../brak_uprawnien.php');} ?>