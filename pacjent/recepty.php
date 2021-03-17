<?php
    session_start();
    if($_SESSION['role'] == 'pacjent')
    {
        include('../connect.php');
?>
<!doctype html>
<html lang="pl">
    <head>
        <?php include('head.php'); ?>
        <title>Pacjent - e-recepty</title>
        <link rel="stylesheet" type="text/css" href="pacjent.css">

        <style>
            ul
            {
                list-style-type: none;
                padding-left: 0;
            }
            i
            {
                padding-right: 10px;
            }

        </style>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <div class="container">
            <div class="row p-3">  
                <div class="col-md-12 text-center bg-light"  style="border-radius:10px;">
                    <?php include('menu.php') ?>
                </div>
            </div>
            <div class="row p-3 min-vh-100"> 
                <div class="col-md-12 p-3 text-center" id="content">
                <h2 style="font-weight: bold;padding: 10px;">
		                 Aby odebrać e-receptę podaj w aptece swój pesel oraz kod.
                        </h2>
                    <div class="col-md-7 mx-auto text-left">
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
                            $query = pg_query_params($dbconn, 'SELECT * from pacjent_recepty WHERE id_pacjent=$1', array($_SESSION['id_pacjent'])) or die('Query failed: ' . pg_last_error());;
                            while ($row = pg_fetch_assoc($query)) 
                            { 
                                if($temp==(-1))
                                {
                                    $temp = $row['id_e_recepta'];
                        ?>
                               <div class="card mb-3">
                                    <div class="card-header">E-recepta<a href="wizyty/profil_lekarza.php?id=<?php echo $row['id_lekarz']; ?>" class="btn btn-primary float-right"><i class="fas fa-user-md"></i>Profil lekarza</a></div>
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
                                    <div class="card-header">E-recepta <a href="wizyty/profil_lekarza.php?id=<?php echo $row['id_lekarz']; ?>" class="btn btn-primary float-right"><i class="fas fa-user-md"></i>Profil lekarza</a>
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
            </div>      
        </div>
    </div>
  </body>
</html>
<?php } else { header('Location: ../brak_uprawnien.php');} ?>