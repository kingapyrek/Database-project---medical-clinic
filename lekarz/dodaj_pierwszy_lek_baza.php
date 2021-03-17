<?php
    session_start();
    if($_SESSION['role'] == 'lekarz')
    {
        include('../connect.php');
        $kod =  (int)str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT);

        $insert = pg_query_params('INSERT INTO e_recepta(id_pacjent, id_lekarz, kod) VALUES ($1,$2,$3) RETURNING id_e_recepta', array($_SESSION['id_pacjent'], $_SESSION['id_lekarz'], $kod))  or die('Query failed: ' . pg_last_error());;
        $row = pg_fetch_assoc($insert);
        $_SESSION['id_recepta'] = $row['id_e_recepta'];
        $nazwa = $_POST['nazwa'];
        $sub = $_POST['sub'];
        $dawka = $_POST['dawka'];

        $insert2 = pg_query_params('INSERT INTO lek(nazwa, substancja) VALUES ($1, $2) RETURNING id_lek', array($nazwa, $sub));//  or die('Query failed: ' . pg_last_error());;
        if(pg_num_rows($insert2)==0)
        {  
            $lek = pg_query_params('SELECT * FROM lek WHERE nazwa=$1 AND substancja=$2 ', array($nazwa, $sub))  or die('Query failed: ' . pg_last_error());;
            $lek_row = pg_fetch_assoc($lek);
            
        }
        else
        {
           $lek_row = pg_fetch_assoc($insert2);
        }
        

        $insert3 = pg_query_params('INSERT INTO e_recepta_lek(id_e_recepta, id_lek, dawkowanie) VALUES ($1, $2, $3)', array($_SESSION['id_recepta'], $lek_row['id_lek'], $dawka))  or die('Query failed: ' . pg_last_error());;
        echo "<script>
        alert('Dodano lek do e-recepty!');
        </script>";
?>
<!doctype html>
<html lang="pl">
    <head>
        <?php include('head.php'); ?>
        <title>E-recepta</title>
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
                <div class="col-md-12 p-3" id="content">
                    <h2 style="font-weight: bold;padding: 20px; text-align:center;"> Czy chcesz dodać kolejny lek do recepty? </h2>
                    <div class="col-md-4 mx-auto">        
                        <a href="kolejny_lek.php" class="btn btn-success"><i class="fas fa-plus"></i>Tak, dodaj kolejny</a>
                        <a href="koniec_recepta.php" class="btn btn-danger"><i class="fas fa-times"></i>Nie, zakończ</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php }else{
	header('Location: ../brak_uprawnien.php');} ?>