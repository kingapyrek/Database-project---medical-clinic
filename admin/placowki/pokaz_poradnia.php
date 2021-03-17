<?php 
	session_start();
	if($_SESSION['role']=='admin')
	{
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	   <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" href="../admin.css">


    <!-- Latest compiled and minified CSS -->
        
    <title>Wybierz placówkę</title>
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
		           Wyświetl poradnie w danej placówce
		      </h2>
            <form role="form" method="get" action="pokaz_poradnia_baza.php">
              <select class="form-select" aria-label="Default select example" name="test"  required>
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
              <button type="submit" class="btn btn-primary">Wyświetl poradnie</button>
            </form>
        </div>
      </div>
    </div>
  </body>
</html>
<?php }else{
	header('Location: ../../brak_uprawnien.php');} ?>
