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
        <title>Wybierz placówkę</title>
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
                <div class="col-md-12 p-3 text-center" id="content">
                    <div class="col-md-8 mx-auto">
                        <h2 style="font-weight: bold;padding: 10px;"> Wybierz placówkę </h2>
                        <form role="form" method="get" action="wybierz_poradnia.php">
                            <select class="form-select" aria-label="Default select example" name="placowka" style="margin: 10px; padding: 5px;" required>
                                <option selected disabled>Wybierz</option>
                                <?php
                                    include('../../connect.php');
                                    $result = pg_query($dbconn, 'SELECT * FROM placowka') or die('Query failed: ' . pg_last_error());;
                                    while ($row = pg_fetch_assoc($result)) 
                                    {
                                        $adres = pg_query_params($dbconn, 'SELECT * FROM adres WHERE id_adres=$1', array($row['id_adres'])) or die('Query failed: ' . pg_last_error());;
                                        $adres_row = pg_fetch_assoc($adres);
                                ?>
                                <option value="<?php echo $row['id_placowka'] ?>"><?php echo $row['nazwa'] . " - " . $adres_row['miasto']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <button type="submit" class="btn btn-primary">Wybierz placówkę</button>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php }else{
	header('Location: ../brak_uprawnien.php');} ?>