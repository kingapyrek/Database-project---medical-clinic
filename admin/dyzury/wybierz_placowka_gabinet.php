<?php 
	session_start();
	if($_SESSION['role']=='admin')
	{
		?>
<!doctype html>
<html lang="en">
  <head>
    <?php include('../head.php') ?> 
    <title>Wyświetl poradnie</title>
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
		           Wyświetl poradnie w danej placówce
		      </h2>
            <form role="form" method="get" action="wyswietl_poradnie.php">
              <select class="form-select" aria-label="Default select example" name="placowka" style="margin: 10px; padding: 5px;"  required>
                <option selected disabled>Wybierz</option>
                  <?php
                    include('../connect.php');
                    $result = pg_query($dbconn, 'SELECT * FROM placowka') or die('Query failed: ' . pg_last_error());;
                    while ($row = pg_fetch_assoc($result)) 
                    {
                  ?>
                <option value="<?php echo $row['id_placowka'] . '|' . $row['nazwa'] ?>"><?php echo $row['nazwa'] ?></option>
                  <?php
                    }
                  ?>
              </select>
              <button type="submit" class="btn btn-primary">Wybierz placówkę</button>
            </form>
        </div>
      </div>
    </div>
  </body>
</html>
<?php }else{
	header('Location: ../../brak_uprawnien.php');} ?>