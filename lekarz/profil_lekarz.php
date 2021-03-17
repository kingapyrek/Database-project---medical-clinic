<?php
    session_start();
    if($_SESSION['role'] == 'lekarz')
    { 
?>
<!doctype html>
<html lang="pl">
    <head>
        <?php include('head.php'); ?>
        <link rel="stylesheet" type="text/css" href="pacjent.css">
        <title>Twój profil</title>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <?php
            include('../connect.php');    
            $query = pg_query_params($dbconn, 'SELECT * from lekarz WHERE id_lekarz=$1;', array($_SESSION['id_lekarz'] )) or die('Query failed: ' . pg_last_error());;
    
            $row = pg_fetch_assoc($query);
        ?>

        <div class="container">
            <div class="row p-3">  
                <div class="col-md-12 text-center bg-light"  style="border-radius:10px;">
                    <?php include('menu.php') ?>
                </div>
            </div>
            <div class="row p-3 min-vh-100"> 
                <div class="col-md-12 p-3" id="content">
                    <div class="col-md-8 mx-auto">
                        <h2 style="font-weight: bold;padding: 20px; text-align:center;"> <?php echo $row['imie'] . " " . $row['nazwisko'] ?></h2>
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
                                    <h6 class="mb-0">Pesel</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                    <?php echo $row['pesel']; ?>
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
            			    </div>
						  </div>
						  <br>
              		    <h2 style="font-weight: bold;padding: 20px;text-align:center;">
		                Twoje specjalizacje
                        </h2>
                        <?php
                                $query = pg_query_params($dbconn, 'SELECT * from specjalizacja JOIN lekarz_specjalizacja ON lekarz_specjalizacja.id_specjalizacja= specjalizacja.id_specjalizacja JOIN lekarz on lekarz.id_lekarz =  lekarz_specjalizacja.id_lekarz WHERE lekarz_specjalizacja.id_lekarz=$1;', array($_SESSION['id_lekarz'] )) or die('Query failed: ' . pg_last_error());;
                                while ($row = pg_fetch_assoc($query)) 
                                {
                        ?>
		        	    <div class="card mb-3">
						    <div class="card-header">Specjalizacje</div>
            			    <div class="card-body">
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
                                <br>
                            </div>
                        </div>
		                  <?php } ?>
				        <br>
				        <h2 style="font-weight: bold;padding: 20px;text-align:center;">
					    Dyżury
						</h2>
						<?php
                                    include('connect.php');
                                    $query = pg_query_params($dbconn, 'SELECT * from lekarz_dyzury WHERE id_lekarz=$1 ORDER BY dzien;', array($_SESSION['id_lekarz'])) or die('Query failed: ' . pg_last_error());;
                                    while ($row = pg_fetch_assoc($query)) 
                                    {
                                ?>
				        <div class="card mb-3">
						    <div class="card-header">Dyżur</div>
            			    <div class="card-body">
                                
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
                            </div>
              		    </div>
						<?php } ?>
						<br>
            			
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php }else{
	header('Location: ../brak_uprawnien.php');} ?>