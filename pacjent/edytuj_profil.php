<?php
    session_start();
    if($_SESSION['role'] == pacjent)
    {
?>
<!doctype html>
<html lang="pl">
    <head>
        <?php include('head.php'); ?>
        <title>Edytuj profil</title>
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
                    <div class="col-md-8 mx-auto">
                        <h2 style="padding:10px;"> Edytuj profil </h2>
                        <form role="form" method="post" action="edytuj_profil_baza.php?id=<?php echo $id; ?>">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Imię</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="imie" value="<?php echo $row['imie']; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nazwisko</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="nazwisko" value="<?php echo $row['nazwisko']; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Data urodzenia</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="data" value="<?php echo $row['data_urodzenia']; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="email" value="<?php echo $row['email']; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Pesel</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="pesel" value="<?php echo $row['pesel']; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Miasto</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="miasto" value="<?php echo $adres_row['miasto']; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Ulica</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="ulica" value="<?php echo $adres_row['ulica']; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Numer</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="numer" value="<?php echo $adres_row['numer']; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Kod pocztowy</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="kod" value="<?php echo $adres_row['kod_pocztowy']; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group row" style="float: left;">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <button type="submit" class="btn btn-primary">Zapisz</button>
                                </div>
                            </div>
            </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php }else{
	header('Location: ../brak_uprawnien.php');} ?>