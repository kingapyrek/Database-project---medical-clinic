<?php
    session_start();
    if($_SESSION['role']=='pacjent')
    {
?>
<!doctype html>
<html lang="pl">
  <head>
    <?php include('head.php'); ?>
    <title>Twój profil</title>
    <link rel="stylesheet" type="text/css" href="pacjent.css">

  </head>
  <body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <?php
	    include('../connect.php');
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
                <h2 style="padding:10px;"> Twój profil </h2>
                <div class="col-md-8 mx-auto">
                    <div class="card mb-3">
						<div class="card-header">Pacjent</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Imię</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $row['imie']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Nazwisko</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $row['nazwisko']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Data urodzenia</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $row['data_urodzenia']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                <?php echo $row['email']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                <h6 class="mb-0">Pesel</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                <?php echo $row['pesel']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                <h6 class="mb-0">Miasto</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                <?php echo $adres_row['miasto']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Ulica</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $adres_row['ulica']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Numer</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $adres_row['numer']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Kod pocztowy</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $adres_row['kod_pocztowy']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3"><br>
                                    <a href="edytuj_profil.php"> <button class="btn btn-success btn-ml rounded-2" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i> Edytuj</button></a>
                                </div>
                            </div>
                        </div>
              		</div>
              		<h2 style="font-weight: bold;padding: 10px;">
		                Twoje dolegliwości
		        	</h2>
		        	<div class="card mb-3">
						<div class="card-header">Dolegliwości</div>
            			<div class="card-body">
                            <?php
                                $query = pg_query_params($dbconn, 'SELECT * from dolegliwosc JOIN pacjent_dolegliwosc ON pacjent_dolegliwosc.id_dolegliwosc = dolegliwosc.id_dolegliwosc JOIN pacjent on pacjent.id_pacjent = pacjent_dolegliwosc.id_pacjent WHERE pacjent_dolegliwosc.id_pacjent=$1;', array($_SESSION['id_pacjent'])) or die('Query failed: ' . pg_last_error());;
                                while ($row = pg_fetch_assoc($query)) 
                                {

                            ?>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Nazwa</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $row['nazwa']; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Opis</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $row['opis']; ?>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </div>
  </body>
</html>
<?php } else { header('Location: ../brak_uprawnien.php');} ?>