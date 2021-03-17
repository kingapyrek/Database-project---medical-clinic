<?php
  session_start();
  if($_SESSION['role']=='admin')
	{
?>
<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <?php include('../head.php') ?>
    <title>Edytuj pacjenta</title>
    <style>
    body
      {
        background-image: url('../background3.jpg') ;
        background-size: cover;
        font-family: 'Lato', sans-serif;
      
      }
    </style>
  </head>
  <body>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
     
  	<div class="container-fluid">
	    <div class="row">  
	        <div class="col-md-3" style="padding: 0px;">
				<?php include 'menu.php';?>            
			</div>
		 	<div class="col-md-8" style="margin-left: 350px;">
		        <h2 style="font-weight: bold;padding: 10px;">
		            Edytuj pacjenta
		        </h2>

            <?php

            include('../connect.php');

            $id = $_GET['id'];

            $result = pg_query_params($dbconn, 'SELECT * FROM pacjent WHERE id_pacjent = $1', array($id)) or die('Query failed: ' . pg_last_error());;

            $row = pg_fetch_assoc($result);
            $adres = pg_query_params($dbconn, 'SELECT * FROM adres WHERE id_adres=$1', array($row['id_adres'])) or die('Query failed: ' . pg_last_error());;
            $adres_row = pg_fetch_assoc($adres);
            ?>
             <div class="col-lg-8 push-lg-4 personal-info">
             <form role="form" method="post" action="edytuj_pacjent_baza.php?id=<?php echo $id; ?>">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Imię</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="imie" value="<?php echo $row['imie']; ?>"  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Nazwisko</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="nazwisko" value="<?php echo $row['nazwisko']; ?>"  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Data urodzenia</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="data" value="<?php echo $row['data_urodzenia']; ?>"  required />
                    </div>
                </div>
                   <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="email" value="<?php echo $row['email']; ?>"  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Pesel</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="pesel" value="<?php echo $row['pesel']; ?>"  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Miasto</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="miasto" value="<?php echo $adres_row['miasto']; ?>"  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Ulica</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="ulica" value="<?php echo $adres_row['ulica']; ?>"  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Numer</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="numer" value="<?php echo $adres_row['numer']; ?>"  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Kod pocztowy</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="kod" value="<?php echo $adres_row['kod_pocztowy']; ?>"  required />
                    </div>
                </div>
                <div class="form-group row">
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
	header('Location: ../../brak_uprawnien.php');} ?>