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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" href="../admin.css">
    <title>Profil lekarza</title>
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
    <?php
	    include('../connect.php');
	    $id = $_GET['id'];

	    $query = pg_query_params($dbconn, 'SELECT * from lekarz WHERE id_lekarz=$1;', array($id )) or die('Query failed: ' . pg_last_error());;

	    $row = pg_fetch_assoc($query);
	?>
  	<div class="container-fluid">
	    <div class="row">  
	        <div class="col-md-3" style="padding: 0px;">
				<?php include 'menu.php';?>            
			</div>
		 	<div class="col-md-8" style="margin-left: 370px;">
		        <h2 style="font-weight: bold;padding: 10px;">
		            Profil lekarza
		        </h2>
		        
					<div class="card mb-3">
						<div class="card-header">Lekarz</div>
            			<div class="card-body">
              				<div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Imię</h6>
			                    </div>
                    			<div class="col-sm-9 text-secondary">
                      				<?php echo $row['imie']; ?>
                 			   	</div>
              				</div>
              				<hr>
		                  	<div class="row">
		                    	<div class="col-sm-3">
		                      		<h6 class="mb-0">Nazwisko</h6>
		                    	</div>
		                    	<div class="col-sm-9 text-secondary">
		                      		<?php echo $row['nazwisko']; ?>
		                    	</div>
		                  	</div>
              				<hr>
		                  	<div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Email</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                      <?php echo $row['email']; ?>
			                    </div>
		                  	</div>
             				<hr>
		                  	<div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Telefon</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['telefon']; ?>
			                    </div>
		                  	</div>
              				<hr>
		                  	<div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Pesel</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['pesel']; ?>
			                    </div>
		                  	</div>
		                  	<div class="row">
		                  	<div class="col-sm-3"><br>
		                  	<a class='btn btn-info btn-s' href="edytuj_lekarz.php?id=<?php echo $row['id_lekarz']?>"><span class="glyphicon glyphicon-edit"></span> Edytuj</a>
		                  	</div>
		              		</div>
            			</div>
              		</div>
              		<h2 style="font-weight: bold;padding: 10px;">
		            Specjalizacje lekarza <a class='btn btn-success btn-s' href="dodaj_specjalizacja.php?id=<?php echo $row['id_lekarz'] ?>" style="border-radius: 50%;"><span class="glyphicon glyphicon-edit"></span> Dodaj</a>
		        	</h2>
		        	<div class="card mb-3">
						<div class="card-header">Specjalizacje</div>
            			<div class="card-body">
		        	<?php
		        		//include('connect.php');
	    				$query = pg_query_params($dbconn, 'SELECT * from specjalizacja JOIN lekarz_specjalizacja ON lekarz_specjalizacja.id_specjalizacja= specjalizacja.id_specjalizacja JOIN lekarz on lekarz.id_lekarz =  lekarz_specjalizacja.id_lekarz WHERE lekarz_specjalizacja.id_lekarz=$1;', array($id )) or die('Query failed: ' . pg_last_error());;
	    				while ($row = pg_fetch_assoc($query)) 
						{

		        	?>
		        	<div class="row">
			                <div class="col-sm-3">
			                    <h6 class="mb-0">Nazwa</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['nazwa']; ?>
			                    </div>
		                  	</div>
		                  	<hr>
		                  	<div class="row">
		                  	<div class="col-sm-3">
			                      <h6 class="mb-0">Uczelnia</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['uczelnia']; ?>
			                    </div>
		                  	</div>
		                  	<hr>
		                  	<div class="row">
		                  	<div class="col-sm-3">
			                      <h6 class="mb-0">Rok otrzymania</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['rok_otrzymania']; ?>
			                    </div>
		                  	</div>
						<div class="row">
		                  	<div class="col-sm-3"><br>
		                  	<a class='btn btn-info btn-s' href="edytuj_specjalizacja.php?id=<?php echo $row['id_specjalizacja'] ?>"><span class="glyphicon glyphicon-edit"></span> Edytuj</a>
		                  	<a class='btn btn-danger btn-s' href="edytuj_placowka.php"><span class="glyphicon glyphicon-edit"></span> Usuń</a>

		                  </div>
		              </div>
		              <br>
		                  <?php } ?>

				</div>
						</div>
				<br>
				<h2 style="font-weight: bold;padding: 10px;">
					Dyżury
						</h2>
				<div class="card mb-3">
						<div class="card-header">Dyżury</div>
            			<div class="card-body">
						<?php
		        		//include('connect.php');
	    				$query = pg_query_params($dbconn, 'SELECT * from lekarz_dyzury WHERE id_lekarz=$1 ORDER BY dzien;', array($id )) or die('Query failed: ' . pg_last_error());;
	    				while ($row = pg_fetch_assoc($query)) 
						{

						?>
						<br>
              				<div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Dzień</h6>
			                    </div>
                    			<div class="col-sm-9 text-secondary">
                      				<?php echo $row['dzien']; ?>
                 			   	</div>
              				</div>
              				<hr>
		                  	<div class="row">
		                    	<div class="col-sm-3">
		                      		<h6 class="mb-0">Początek</h6>
		                    	</div>
		                    	<div class="col-sm-9 text-secondary">
		                      		<?php echo $row['poczatek']; ?>
		                    	</div>
		                  	</div>
              				<hr>
		                  	<div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Koniec</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                      <?php echo $row['koniec']; ?>
			                    </div>
		                  	</div>
             				<hr>
		                  	<div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Numer gabinetu</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['numer']; ?>
			                    </div>
		                  	</div>
							  <hr>
							  <div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Budynek</h6>
								</div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['budynek']; ?>
			                    </div>
							  </div>
							  <hr>
							  <div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">pietro</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['pietro']; ?>
			                    </div>
							  </div>
							  <hr>
		                  	<div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Nazwa typu poradni</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['poradnia_nazwa']; ?>
			                    </div>
							  </div>
							  <hr>
							  <div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Nazwa placówki</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['placowka_nazwa']; ?>
			                    </div>
		                  	</div>
		                  	<div class="row">
		                  	<div class="col-sm-3"><br>
		                  	<a class='btn btn-info btn-s' href="edytuj_lekarz.php?id=<?php echo $row['id_lekarz']?>"><span class="glyphicon glyphicon-edit"></span> Edytuj</a>
		                  	</div>
							  </div>
							  <?php } ?>
							  <br>
            			</div>
              		</div>
			</div>
		</div>
		</div>
	</body>
</html>
<?php }else{
	header('Location: ../../brak_uprawnien.php');} ?>



















