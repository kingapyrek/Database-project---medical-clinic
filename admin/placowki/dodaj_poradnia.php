<?php
  session_start();
  $id_placowka = $_GET['id'];
  if($_SESSION['role']=='admin')
	{
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" href="../admin.css">
    <title>Dodaj poradnię</title>
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
		 	<div class="col-md-8" style="margin-left: 370px;">
		        <h2 style="font-weight: bold;padding: 10px;">
		           Dodaj poradnię
		        </h2>
             <div class="col-lg-8 push-lg-4 personal-info">
             <form role="form" method="post" action="dodaj_poradnia_baza.php">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Budynek</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="budynek" value=""  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Piętro</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="pietro" value=""  required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Typ</label>
                    <div class="col-lg-9">
                      <select class="form-select" aria-label="Default select example" name="typ"  required>
                        <option selected disabled>Wybierz</option>
                        <?php
                          include('../connect.php');
                          $result = pg_query($dbconn, 'SELECT * FROM poradnia_typ') or die('Query failed: ' . pg_last_error());;
                          while ($row = pg_fetch_assoc($result)) 
                          {
                        ?>
                            <option value="<?php echo $row['id_typ']?>"><?php echo $row['nazwa'] ?></option>
                        <?php
                           }
                        ?>
                      </select>
                    </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">ID wybranej placówki</label>
                  <div class="col-lg-9">
                    <input type="text" name="placowka" value="<?php echo $id_placowka ?>" class="field left" readonly required>
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