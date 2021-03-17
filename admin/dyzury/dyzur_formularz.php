<?php 
    session_start();
   
	if($_SESSION['role']=='admin')
	{
        $_SESSION['id_lekarz'] = $_GET['id'];
        include('../connect.php');
        $placowka = pg_query_params('SELECT * FROM placowka WHERE id_placowka=$1', array($_SESSION['id_placowka']));
        $row_placowka = pg_fetch_assoc($placowka);
    
        $poradnia = pg_query_params('SELECT * FROM poradnia WHERE id_poradnia=$1', array($_SESSION['id_poradnia']));
        $row_poradnia = pg_fetch_assoc($poradnia);
    
        $poradnia_typ = pg_query_params('SELECT * FROM poradnia_typ WHERE id_typ=$1', array($row_poradnia['id_typ']));
        $row_typ = pg_fetch_array($poradnia_typ);


?>
<!doctype html>
<html lang="en">
  <head>
    <?php include('../head.php') ?>
    <title>Dodaj dyżur</title>
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
		            Dodaj dyżur w <?php echo $row_placowka['nazwa'] . " w poradni " . $row_typ['nazwa']; ?>
                   
		        </h2>
                <br>
             <div class="col-lg-8 push-lg-4 personal-info">
             <form role="form" method="post" action="dodaj_dyzur_baza.php">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Dzień</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="date" name="dzien" value=""   required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Początek - godzina</label>
                    <div class="col-lg-9">
                        <input  class="form-control" type="time" name="poczatek" value=""  step="1800"  required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Koniec - godzina</label>
                    <div class="col-lg-9">
                    <input class="form-control" type="time" name="koniec" value="" step="1800"  required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Gabinet</label>
                    <div class="col-lg-9">
                        <select class="form-select" aria-label="Default select example" name="gabinet"  required>
                            <option selected disabled>Wybierz</option>
                            <?php
                               
                                $result = pg_query_params($dbconn, 'SELECT * FROM gabinet WHERE id_poradnia=$1', array($_SESSION['id_poradnia'])) or die('Query failed: ' . pg_last_error());;
                                while ($row = pg_fetch_assoc($result)) 
                                {
                            ?>
                            <option value="<?php echo $row['id_gabinet']?>"><?php echo $row['numer'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
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
	header('Location: ../../brak_uprawnien.php');} ?>