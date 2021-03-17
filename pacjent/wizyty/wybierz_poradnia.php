<?php
    session_start();
    if($_SESSION['role'] =='pacjent')
    {
?>
<!doctype html>
<html lang="pl">
    <head>
        <?php include('../head.php'); ?>
        <link rel="stylesheet" type="text/css" href="../pacjent.css">
        <title>Wybierz poradnię</title>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <?php
            include('../../connect.php');
            $query = pg_query_params($dbconn, 'SELECT * from pacjent WHERE id_pacjent=$1;', array((int)$_SESSION['id_pacjent'])) or die('Query failed: ' . pg_last_error());;
            

            $row = pg_fetch_assoc($query);
            $adres = pg_query_params($dbconn, 'SELECT * FROM adres WHERE id_adres=$1', array($row['id_adres'])) or die('Query failed: ' . pg_last_error());;
            $adres_row = pg_fetch_assoc($adres);
        ?>

        <div class="container">
            <div class="row p-3">  
                <div class="col-md-12 text-center bg-light"  style="border-radius:10px;">
                    <?php include('menu.php') ?>
                </div>
            </div>
            <div class="row p-3 min-vh-100"> 
                <div class="col-md-12 p-3 text-center" id="content">
                    <div class="col-md-8 mx-auto">
                    <h2 style="font-weight: bold;padding: 10px;"> Wybierz poradnię </h2>
                        <ul class="list-group list-group-flush">
                        <?php
                            include('../../connect.php');
                            $_SESSION['id_placowka'] = $_GET['placowka'];
                            
                            $por = pg_query_params($dbconn, 'SELECT * FROM poradnia WHERE id_placowka=$1', array($_SESSION['id_placowka'])) or die('Query failed: ' . pg_last_error());;
                            if(pg_num_rows($por) == 0)
                            {
                                echo "Nie ma narazie żadnych poradni!";
                            }

                            while($row = pg_fetch_assoc($por))
                            {
                                $typ = pg_query_params($dbconn, 'SELECT * FROM poradnia_typ WHERE id_typ=$1', array($row['id_typ'])) or die('Query failed: ' . pg_last_error());;
                                $row_typ = pg_fetch_assoc($typ);  
                        ?>
                            <li class="list-group-item"><a href="poradnia_wizyty.php?id=<?php echo $row['id_poradnia'] ?>"><?php echo $row_typ['nazwa'];?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php }else{
	header('Location: ../brak_uprawnien.php');} ?>