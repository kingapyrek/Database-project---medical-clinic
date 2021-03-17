<?php
    $id = explode('|', $_GET['placowka']);
    session_start();
    if($_SESSION['role']=='admin')
    {
      $_SESSION['id_placowka'] = $id[0];
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
		 	  <div class="col-md-4" style="margin-left: 10px;">
              <h2 style="font-weight: bold;padding: 10px;">
              
		           Poradnie w placówce <?php echo $id[1] ?>
              </h2>
              <h3  style="padding: 10px;">Wybierz poradnię do dyżuru </h3>
              <ul class="list-group list-group-flush">
              <?php
                include('../connect.php');
                
                $por = pg_query_params($dbconn, 'SELECT * FROM poradnia WHERE id_placowka=$1', array($_SESSION['id_placowka'])) or die('Query failed: ' . pg_last_error());;
                if(pg_num_rows($por) == 0)
                {
                    echo "Nie ma narazie żadnych poradni!";
                }

                while($row = pg_fetch_assoc($por))
                {
                    $typ = pg_query_params($dbconn, 'SELECT * FROM poradnia_typ WHERE id_typ=$1', array($row['id_typ'])) or die('Query failed: ' . pg_last_error());;
                    $row_typ = pg_fetch_assoc($typ);  
                  ?>
                <li class="list-group-item"><a href="wyswietl_lekarze_poradnia.php?id=<?php echo $row['id_poradnia'] ?>"><?php echo $row_typ['nazwa'];?></li>
                    <?php } ?>
                </ul>
              </div>
    </div>
    </div>
    </body>
    </html>
    <?php }else{
	header('Location: ../../brak_uprawnien.php');} ?>