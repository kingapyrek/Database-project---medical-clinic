 <?php  
	//$id = $_POST['test'];
	session_start();
	if($_SESSION['role']=='admin')
	{
    	$test = explode('|', $_GET['test']);
           // echo $val; 
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
    <title>Poradnie</title>
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
		            Poradnie w placówce <?php echo $test[1];?>
		        </h2>
		        <br><br>
			    <table class="table table-striped custab">
				    <thead>
					        <tr>
					            <th>ID</th>
					            <th>Budynek</th>
					            <th>Piętro</th>
					            <th>ID typ</th>
					            <th>Nazwa</th>
					            <th>Opis</th>
					            <th class="text-center">Edytuj</th>
					        </tr>
				    </thead>
		            <?php

						

		            	include('../connect.php');

		            	$poradnia = pg_query_params($dbconn, 'SELECT * FROM poradnia WHERE id_placowka=$1', array($test[0])) or die('Query failed: ' . pg_last_error());;

		            	

						while ($row = pg_fetch_assoc($poradnia)) 
						{
							$poradnia_typ =  pg_query_params($dbconn, 'SELECT * FROM poradnia_typ WHERE id_typ=$1', array($row['id_typ'])) or die('Query failed: ' . pg_last_error());;
							
							$row_typ = pg_fetch_assoc($poradnia_typ);
						?>
						  <tr>
						    <td><?php echo $row['id_poradnia']; ?></td>
						    <td><?php echo $row['budynek']; ?></td>
						    <td><?php echo $row['pietro']; ?></td>
						    <td><?php echo $row['id_typ']; ?></td>
						    <td><?php echo $row_typ['nazwa']; ?></td>
						    <td><?php echo $row_typ['opis']; ?></td>
						     <td class="text-center"><a class='btn btn-info btn-s' href="edytuj_poradnia.php?id=<?php echo $row['id_poradnia'] . '|' . $test[0]; ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a> </td>
						  </tr>	
						<?php
						}
						?>
			    </table>
			    <br>
			    <h2>Dodaj nową poradnię</h2>
			    <a href="dodaj_poradnia.php?id=<?php echo $test[0];?>">
			     <i class="fas fa-plus-circle fa-5x" style="color: green"></i></a>
		    </div>



	    </div>
	</div>

  </body>
</html>
<?php }else{
	header('Location: ../../brak_uprawnien.php');} ?>