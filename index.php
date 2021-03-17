<?php ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <title>Medico</title>
    <style>
      body
      {
        background-image: url('back.jpg');
        background-size: cover;
        font-family: 'Lato', sans-serif;
      }
      #panel
      {
        background-color: rgba(255,255,255, 0.8);
        padding: 10px;
        border-radius: 10px;
        height: content-max;
        font-size: 20px;
      }
      a
      {
        text-decoration: none;
        color : black;
        display: inline;
      }
    </style>
  </head>
  <body>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <div class="jumbotron d-flex align-items-center min-vh-100">
      <div class="container text-center">
        <div class="row">
          <div class="col-sm-3 offset-1" id="panel">
            <a href="zaloguj_lekarz.php">
              <i class="fas fa-user-md fa-4x"></i>
              <br>
              <br>
              <b>Zaloguj się jako lekarz</b>
            </a>
          </div>  
      
          <div class="col-sm-3 offset-1" id="panel">
            <a href="zaloguj_pacjent.php">
             <i class="fas fa-procedures fa-4x"></i>
                <br>
                <br>
                <b>Zaloguj się jako pacjent</b> 
            </a>
          </div>
       
        
          <div class="col-sm-3 offset-1" id="panel">
            <a href="zaloguj_admin.php">
                <i class="fas fa-hospital fa-4x"></i>
                <br>
                <br>
                <b>Zaloguj się jako admin</b>
            </a>
          </div>

        </div>
      </div>
    </div>
  </body>
</html>