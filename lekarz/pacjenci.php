<?php
    session_start();
    if($_SESSION['role'] == 'lekarz')
    {
?>
<!doctype html>
<html lang="pl">
    <head>
        <?php include('head.php'); ?>
        <link rel="stylesheet" type="text/css" href="lekarz.css">
        <title>Twoi pacjenci</title>
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
                        <h2 style="font-weight: bold;padding: 10px; text-align:center;"> Twoi pacjenci </h2>
                        <?php
                            include('../connect.php');
                            $wizyty = pg_query_params($dbconn, 'SELECT * from lekarz_pacjenci WHERE id_lekarz=$1 ORDER BY nazwisko, imie;', array((int)$_SESSION['id_lekarz'])) or die('Query failed: ' . pg_last_error());;
                            while($row = pg_fetch_assoc($wizyty))
                            {

                        ?>
                        
                        <div class="card m-3">
                            <h5 class="card-header">Pacjent</h5>
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-user-injured"></i><?php echo $row['imie'] . " " . $row['nazwisko'] ?></h5>
                                <p class="card-text">
                                    <ul>
                                        <li><i class="fas fa-calendar-alt"></i><?php echo $row['data_urodzenia']?> </li>
                                        <li><i class="fas fa-id-card"></i><?php echo $row['pesel'] ?></li>
                                        <li><i class="fas fa-envelope"></i><?php echo $row['email']; ?></li>     
                                    </ul>
                                    <a href="profil_pacjent.php?id=<?php echo $row['id_pacjent']; ?>" class="btn btn-primary"><i class="fas fa-id-card"></i>Profil</a>
                                    <a href="dodaj_dolegliwosc.php?id=<?php echo $row['id_pacjent']; ?>" class="btn btn-primary"><i class="fas fa-folder-plus"></i>Dodaj dolegliwość</a>
                                    <a href="pierwszy_lek.php?id=<?php echo $row['id_pacjent']; ?>" class="btn btn-primary"><i class="fas fa-pills"></i>Przepisz e-receptę</a>
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