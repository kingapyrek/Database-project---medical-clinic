<?php
	session_start();
  	$id = explode('|', $_GET['id']);
	
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
    <title>Gabinety</title>
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
		 	<div class="col-md-8" style="margin-left: 400px;">
		        <h2 style="font-weight: bold;padding: 10px;">
		            Wszystkie gabinety w poradni
		        </h2>
		        <br><br>
			    <table class="table table-striped custab">
				    <thead>
					        <tr>
					            <th>ID</th>
					            <th>Numer</th>
					            <th class="text-center">Action</th>
					        </tr>
				    </thead>
		            <?php

						include('../connect.php');

						$result = pg_query_params($dbconn, 'SELECT * FROM gabinet WHERE id_poradnia=$1', array($id[1])) or die('Query failed: ' . pg_last_error());;

						while ($row = pg_fetch_assoc($result)) 
						{
						?>
						  <tr>
						    <td><?php echo $row['id_gabinet']; ?></td>
						    <td><?php echo $row['numer']; ?></td>
						     <td class="text-center"><a href="usun_typ.php?id=<?php echo $row['id_typ']; ?>" class="btn btn-danger btn-s"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
						  </tr>	
						<?php
						}
						?>
          </table>
          <br>
          <h2>Dodaj nowy gabinet do poradni</h2>
			    <a href="dodaj_gabinet_poradnia.php?id=<?php echo  $_GET['id'];?>">
			     <i class="fas fa-plus-circle fa-5x" style="color: green"></i></a>	       
		    </div>
	    </div>
	</div>

  </body>
</html>
<?php }else{
	header('Location: ../../brak_uprawnien.php');} ?>