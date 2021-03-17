<?php
    session_start();
    if($_SESSION['role'] == 'lekarz')
    {
        $id_pacjent = $_GET['id'];
?>
<!doctype html>
<html lang="pl">
    <head>
        <?php include('head.php'); ?>
        <link rel="stylesheet" type="text/css" href="lekarz.css">
        <title>Dodaj dolegliwość</title>
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
                        <h2 style="font-weight: bold;padding: 20px; text-align:center;"> Dodaj dolegliwość </h2>
                        <form role="form" method="post" action="dodaj_dolegliwosc_baza.php?id=<?php echo $id_pacjent ?>">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nazwa</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="nazwa" value=""  required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Opis</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control"  name="opis" value="" required></textarea>
                                </div>
                            </div>                
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <button type="submit" class="btn btn-primary">Dodaj</button>
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