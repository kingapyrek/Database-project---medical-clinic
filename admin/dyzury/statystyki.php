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
    <title>Statystyki</title>
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
		        <h3 style="font-weight: bold;padding: 10px;">
                    Ilość lekarzy posiadających dyżury: <?php 
                    
						include('../connect.php');

                        $result = pg_query($dbconn, 'SELECT COUNT(*) as ilosc, AVG(c)::int as dyzury FROM (SELECT id_lekarz, count(id_lekarz) as c FROM lekarz_dyzury GROUP BY id_lekarz) as t') or die('Query failed: ' . pg_last_error());;
                        $row = pg_fetch_assoc($result);
                        echo $row['ilosc'];
                        ?>

		        </h3>
            <h3 style="font-weight: bold;padding: 10px;">
                   Średnia ilość dyżurów lekarza: <?php 
                    echo $row['dyzury'];
					
                        ?>

		        </h3>
            <h3 style="font-weight: bold;padding: 10px;">Lekarze mający ponad 30 godzin dyżuru:</h3>
            <table class="table table-striped custab">
				    <thead>
					        <tr>
					            <th>ID</th>
					            <th>Imię</th>
					            <th>Nazwisko</th>
					            <th>Suma godzin</th>
					            <th class="text-center">Profil</th>
					        </tr>
				    </thead>
		            <?php


						$result = pg_query($dbconn, 'SELECT lekarz.id_lekarz, lekarz.imie, lekarz.nazwisko, t.suma from
            (SELECT id_lekarz, sum(extract(hours from (koniec - poczatek))) as suma  from lekarz_dyzury GROUP BY id_lekarz HAVING sum(extract(hours from (koniec - poczatek))) >30)t
            JOIN lekarz ON lekarz.id_lekarz = t.id_lekarz ORDER BY suma DESC') or die('Query failed: ' . pg_last_error());;



						while ($row = pg_fetch_assoc($result)) 
						{
						?>
						  <tr>
						    <td><?php echo $row['id_lekarz']; ?></td>
						    <td><?php echo $row['imie']; ?></td>
						    <td><?php echo $row['nazwisko']; ?></td>
						    <td><?php echo $row['suma']; ?></td>
						     <td class="text-center"><a class='btn btn-info btn-s' href="../lekarze/lekarz_profil_admin.php?id=<?php echo $row['id_lekarz']; ?>"><span class="glyphicon glyphicon-user"></span>Profil</a> </td>
						  </tr>	
						<?php
						}
						?>
			    </table>		      

           <h3 style="font-weight: bold;padding: 10px;">Ilość godzin dyżuru w danych poradniach:</h3>
            <table class="table table-striped custab">
				    <thead>
					        <tr>
					            <th>ID</th>
					            <th>Nazwa</th>
					            <th>Suma godzin</th>

					        </tr>
				    </thead>
		            <?php


						$result = pg_query($dbconn, 'SELECT DISTINCT lekarz_dyzury.poradnia_nazwa, lekarz_dyzury.id_poradnia, t.suma from 
            (SELECT id_poradnia, sum(extract(hours from (koniec - poczatek))) as suma FROM lekarz_dyzury group by id_poradnia) as t
            JOIN lekarz_dyzury ON lekarz_dyzury.id_poradnia = t.id_poradnia ORDER BY suma DESC') or die('Query failed: ' . pg_last_error());;



						while ($row = pg_fetch_assoc($result)) 
						{
						?>
						  <tr>
						    <td><?php echo $row['id_poradnia']; ?></td>
						    <td><?php echo $row['poradnia_nazwa']; ?></td>
						    <td><?php echo $row['suma']; ?></td>
						  </tr>	
						<?php
						}
						?>
			    </table>		       
 


                </div>
	    </div>
	</div>

  </body>
</html>
<?php }else{
	header('Location: ../../brak_uprawnien.php');} ?>