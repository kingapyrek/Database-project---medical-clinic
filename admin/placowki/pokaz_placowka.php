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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" href="../admin.css">
    <title>Placówki</title>
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
		            Placówki
		        </h2>
		        <br><br>
			    <table class="table table-striped custab">
				    <thead>
					        <tr>
					            <th>ID</th>
					            <th>Nazwa</th>
					            <th>Miasto</th>
					            <th>Ulica</th>
					            <th>Numer</th>
					            <th>Kod pocztowy</th>
					            <th class="text-center">Edytuj</th>
					        </tr>
				    </thead>
		            <!--<tr>
		                <td>1</td>
		                <td>News</td>
		                <td>News Cate</td>
		                <td>News Cate</td>
		                <td>News Cate</td>
		                <td class="text-center"><a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
		            </tr>
		            <tr>
		                <td>2</td>
		                <td>Products</td>
		                <td>Main Products</td>
		                <td>News Cate</td>
		                <td>News Cate</td>
		                <td class="text-center"><a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
		            </tr>
		            <tr>
		                <td>3</td>
		                <td>Blogs</td>
		                <td>Parent Blogs</td>
		                <td>News Cate</td>
		                <td>News Cate</td>
		                <td class="text-center"><a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
		            </tr>-->

		            <?php

						include('../connect.php');

						$result = pg_query($dbconn, 'SELECT * FROM placowka') or die('Query failed: ' . pg_last_error());;



						while ($row = pg_fetch_assoc($result)) 
						{
							$adres = pg_query_params($dbconn, 'SELECT * FROM adres WHERE id_adres = $1', array($row['id_adres'])) or die('Query failed: ' . pg_last_error());;
							$row_adres = pg_fetch_assoc($adres);
						?>
						  <tr>
						    <td><?php echo $row['id_placowka']; ?></td>
						    <td><?php echo $row['nazwa']; ?></td>
						    <td><?php echo $row_adres['miasto']; ?></td>
						    <td><?php echo $row_adres['ulica']; ?></td>
						    <td><?php echo $row_adres['numer']; ?></td>   
						    <td><?php echo $row_adres['kod_pocztowy']; ?></td>   
						     <td class="text-center"><a class='btn btn-info btn-s' href="edytuj_placowka.php?id=<?php echo $row['id_placowka']; ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
						  </tr>	
						<?php
						}
						?>
			    </table>
			   <!--  <br><br>
			    <h2> Dodaj nową placówkę</h2>
			    <br><br>
			   <div class="col-md-4 mx-auto text-center" style="padding: 20px;">

		            <form action="login_admin.php" method="post">
		              <div class="form-outline mb-4">
		                <input name="login" type="login" id="login"  class="form-control" />
		                <label class="form-label" for="login">Login</label>
		              </div>

		              <div class="form-outline mb-4">
		                <input name="password" type="password" id="password" class="form-control" />
		                <label class="form-label" for="password">Hasło</label>
		              </div>

		              <button type="submit" class="btn btn-primary btn-block mb-4">Zaloguj</button>

		              <div class="text-center">
		                <p>Nie masz konta? <a href="#!">Zarejestruj się</a></p>
		              </div>
		              <div class="text-center" id="info" style="font-weight: bold; color: red;">
		                 
		              </div>
		               <p>Your name: <input type="text" name="name" /></p>
		                   <p>Your age: <input type="text" name="age" /></p>
		                   <p><input type="submit" /></p>

		            </form>
          		</div>-->
		       
		    </div>
	    </div>
	</div>

  </body>
</html>
<?php }else{
	header('Location: ../../brak_uprawnien.php');} ?>
