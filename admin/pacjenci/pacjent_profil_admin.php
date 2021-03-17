<?php
  session_start();
  if($_SESSION['role']=='admin')
	{
?>
<!doctype html>
<html lang="en">
  <head>
  	<?php include('../head.php') ?>
    <title>Profil pacjenta</title>
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

        $query = pg_query_params($dbconn, 'SELECT * from pacjent WHERE id_pacjent=$1;', array($id )) or die('Query failed: ' . pg_last_error());;
        

        $row = pg_fetch_assoc($query);
        $adres = pg_query_params($dbconn, 'SELECT * FROM adres WHERE id_adres=$1', array($row['id_adres'])) or die('Query failed: ' . pg_last_error());;
        $adres_row = pg_fetch_assoc($adres);
	?>
  	<div class="container-fluid">
	    <div class="row">  
	        <div class="col-md-3" style="padding: 0px;">
				<?php include 'menu.php';?>            
			</div>
		 	<div class="col-md-8" style="margin-left: 370px;">
		        <h2 style="font-weight: bold;padding: 10px;">
		            Profil pacjenta
		        </h2>
		        
					<div class="card mb-3">
						<div class="card-header">Pacjent</div>
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
		                      		<h6 class="mb-0">Data urodzenia</h6>
		                    	</div>
		                    	<div class="col-sm-9 text-secondary">
		                      		<?php echo $row['data_urodzenia']; ?>
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
			                      <h6 class="mb-0">Pesel</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['pesel']; ?>
			                    </div>
		                  	</div>
              				<hr>
		                  	<div class="row">
			                    <div class="col-sm-3">
			                      <h6 class="mb-0">Miasto</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $adres_row['miasto']; ?>
			                    </div>
                              </div>
                              <hr>
                              <div class="row">
		                    	<div class="col-sm-3">
		                      		<h6 class="mb-0">Ulica</h6>
		                    	</div>
		                    	<div class="col-sm-9 text-secondary">
		                      		<?php echo $adres_row['ulica']; ?>
		                    	</div>
		                  	</div>
                              <hr>
                              <div class="row">
		                    	<div class="col-sm-3">
		                      		<h6 class="mb-0">Numer</h6>
		                    	</div>
		                    	<div class="col-sm-9 text-secondary">
		                      		<?php echo $adres_row['numer']; ?>
		                    	</div>
		                  	</div>
                              <hr>
                              <div class="row">
		                    	<div class="col-sm-3">
		                      		<h6 class="mb-0">Kod pocztowy</h6>
		                    	</div>
		                    	<div class="col-sm-9 text-secondary">
		                      		<?php echo $adres_row['kod_pocztowy']; ?>
		                    	</div>
		                  	</div>
              				<hr>
		                  	<div class="row">
		                  	<div class="col-sm-3"><br>
		                  	<a class='btn btn-info btn-s' href="edytuj_pacjent.php?id=<?php echo $row['id_pacjent']?>"><span class="glyphicon glyphicon-edit"></span> Edytuj</a>
		                  	</div>
		              		</div>
            			</div>
              		</div>
              		<h2 style="font-weight: bold;padding: 10px;">
		            Dolegliwości pacjenta <a class='btn btn-success btn-s' href="dodaj_dolegliwosc.php?id=<?php echo $row['id_pacjent'] ?>" style="border-radius: 50%;"><span class="glyphicon glyphicon-edit"></span> Dodaj</a>
		        	</h2>
		        	<div class="card mb-3">
						<div class="card-header">Dolegliwości</div>
            			<div class="card-body">
		        	<?php
	    				$query = pg_query_params($dbconn, 'SELECT * from dolegliwosc JOIN pacjent_dolegliwosc ON pacjent_dolegliwosc.id_dolegliwosc = dolegliwosc.id_dolegliwosc JOIN pacjent on pacjent.id_pacjent = pacjent_dolegliwosc.id_pacjent WHERE pacjent_dolegliwosc.id_pacjent=$1;', array($id )) or die('Query failed: ' . pg_last_error());;
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
			                      <h6 class="mb-0">Opis</h6>
			                    </div>
			                    <div class="col-sm-9 text-secondary">
			                     <?php echo $row['opis']; ?>
			                    </div>
		                  	</div>
		                  	<hr>
						<div class="row">
		                  	<div class="col-sm-3"><br>
		                  	<a class='btn btn-info btn-s' href="edytuj_dolegliwosc.php?id=<?php echo $id . "|" .$row['id_dolegliwosc'] ?>"><span class="glyphicon glyphicon-edit"></span> Edytuj</a>
		                  	<a class='btn btn-danger btn-s' href="usun_dolegliwosc.php?id=<?php echo $id . "|" . $row['id_dolegliwosc']?>"><span class="glyphicon glyphicon-edit"></span> Usuń</a>

		                  </div>
		              </div>
		              <br>
		                  <?php } ?>
						  

		    	</div>
			</div>
			<h2 style="font-weight: bold;padding: 10px; text-align: center;">
		                E-recepty
                        </h2>
                       
                        <?php /* }
                                    else
                                    {
                                        //stara recepta
                                        $temp = $row['id_e_recepta'];
                                    }*/
                            $temp=-1;
                            $query = pg_query_params($dbconn, 'SELECT * from pacjent_recepty WHERE id_pacjent=$1', array($id)) or die('Query failed: ' . pg_last_error());;
                            while ($row = pg_fetch_assoc($query)) 
                            { 
                                if($temp==(-1))
                                {
                                    $temp = $row['id_e_recepta'];
                        ?>
                               <div class="card mb-3">
                                    <div class="card-header">E-recepta<a href="../lekarze/lekarz_profil_admin.php?id=<?php echo $row['id_lekarz']; ?>" class="btn btn-primary float-right"><i class="fas fa-user-md"></i>Profil lekarza</a></div>
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Lekarz</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $row['imie'] . " " . $row['nazwisko']; ?>

                                            </div>
                                        </div>
                                        <hr>

                                <?php }

                                if($row['id_e_recepta']!=$temp)
                                {
                                    $temp = $row['id_e_recepta'];
                                    
                                        
                                ?>
                                  </div>
                                    </div>
                                  


                            
                                <div class="card mb-3">
                                    <div class="card-header">E-recepta <a href="../lekarze/lekarz_profil_admin.php?id=<?php echo $row['id_lekarz']; ?>" class="btn btn-primary float-right"><i class="fas fa-user-md"></i>Profil lekarza</a>
                                    </div>
                                    <div class="card-body">
                                    <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Lekarz</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $row['imie'] . " " . $row['nazwisko']; ?>

                                            </div>
                                        </div>
                                        <hr>

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
                                                <h6 class="mb-0">Substancja</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $row['substancja']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Dawkowanie</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $row['dawkowanie']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Kod</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $row['kod']; ?>
                                            </div>
                                        </div>
                                        <hr><hr>
                                        
                            <?php 
                                } 
                            else
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
                                                <h6 class="mb-0">Substancja</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $row['substancja']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Dawkowanie</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $row['dawkowanie']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Kod</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $row['kod']; ?>
                                            </div>
                                        </div>
                                        <hr><hr>
                                        
                                        <?php }} ?>
		</div>
	</body>
</html>
<?php }else{
	header('Location: ../../brak_uprawnien.php');} ?>