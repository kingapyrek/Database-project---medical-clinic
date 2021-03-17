<?php
    session_start();
    if($_SESSION['role'] == 'pacjent')
    {
        $_SESSION['id_poradnia'] = $_GET['id'];
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
                    <div class="col-md-8 mx-auto">
                        <h2 style="font-weight: bold;padding: 10px;"> Wybierz wizytę </h2>
                        <?php
                            include('../../connect.php');
                            $query = pg_query_params($dbconn, 'SELECT * from lekarz_dyzury WHERE id_poradnia=$1 ORDER BY dzien, poczatek;', array((int)$_SESSION['id_poradnia'])) or die('Query failed: ' . pg_last_error());;
                            
                            while($row = pg_fetch_assoc($query))
                            {
                                $id_dyzur = $row['id_dyzur'];
                                $check = pg_query($dbconn, "SELECT * FROM dostepnosc_dyzuru('$id_dyzur')") or die('Query failed: ' . pg_last_error());;
                                $res= pg_fetch_row($check);
                                if($res[0] == 't')
                                {
                        ?>
                        <div class="card mt-3">
                            <h5 class="card-header">Wizyta</h5>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['imie'] . " " . $row['nazwisko'] ?></h5>
                                <p class="card-text text-center">
                                    <ul>
                                        <li><i class="fas fa-calendar-alt"></i><?php echo $row['dzien'] ?> </li>
                                        <li><i class="fa fa-clock"></i><?php echo date('H:i',  strtotime($row['poczatek'])) . " - " . date('H:i',  strtotime($row['koniec'])) ?> </li>
                                    </ul>
                                </p>
                                <a href="wybierz_godzina_poradnia.php?id=<?php echo $row['id_dyzur']; ?>" class="btn btn-success"><i class="far fa-check-square"></i>Wybierz</a>
                                <a href="profil_lekarza.php?id=<?php echo $row['id_lekarz']; ?>" class="btn btn-primary"><i class="fas fa-user-md"></i>Profil lekarza</a>
                            </div>
                        </div>
                        <?php } }?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php }else{
	header('Location: ../brak_uprawnien.php');} ?>