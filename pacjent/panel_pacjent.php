<!doctype html>
<html lang="pl">
  <head>
    <?php include('head.php'); ?>
    <title>Panel pacjenta</title>
    <link rel="stylesheet" type="text/css" href="pacjent.css">
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
            <h2 style="padding:10px;"> Witaj w panelu pacjenta! </h2>
            <h4> W menu masz opcję umówienia wizyty, sprawdzenia swoich recept oraz twojego profilu. </h4>
           
    </div>
    </div>
    </div>
  </body>
</html>