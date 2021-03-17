<?php
    session_start();
    if($_SESSION['role']=='admin')
        {

?>
<!doctype html>
<html lang="en">
  <head>
    <?php include('../head.php') ?>
    <title>Dodaj lekarza</title>
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
		            Dodaj lekarza
		        </h2>
             <div class="col-lg-8 push-lg-4 personal-info">
             <form role="form" method="post" action="dodaj_lekarz_baza.php?id=<?php echo $id; ?>">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Imię</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="imie" value=""  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Nazwisko</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="nazwisko" value=""  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                    <div class="col-lg-9">
                    <input class="form-control" type="text" name="email" value=""  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Telefon</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="tel" value=""  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Pesel</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="pesel" value=""   required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Login</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="login" value=""  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Hasło</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="password" name="haslo" value=""  required />
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