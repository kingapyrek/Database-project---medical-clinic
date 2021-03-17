<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"/>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <title>Zaloguj - pacjent</title>
    <style>
      body
      {
        background-image: url('back.jpg');
        background-size: cover;
        font-family: 'Lato', sans-serif;
      }
      form
      {
        background-color: rgba(255,255,255);
        padding: 30px;
        border-radius: 10px;
        height: content-max;
        font-size: 20px;

      }
      a
      {
        color: black;
      }
  
    </style>
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
      <div class="row" style="float: left; width: 100px;">
        <a href="index.php">
          <div class="col-md-4">
            <i class="fas fa-home fa-4x bg-white" style="border-radius: 50%; padding: 20px; margin:10px;" ></i>
            
          </div>
        </a>
        </div>

    <div class="jumbotron d-flex align-items-center min-vh-100">
      <div class="container text-center">
      
         <div class="row">
          <div class="col-md-4 mx-auto">
            
            <form action="login_pacjent.php" method="post">
              <div class="form-outline mb-4"><h2 style="padding:15px;"> Pacjent </h2>
                <input name="login" type="login" id="login"  class="form-control"  required/>
                <label class="form-label" for="login">Login</label>
              </div>

              <div class="form-outline mb-4">
                <input name="password" type="password" id="password" class="form-control"  required/>
                <label class="form-label" for="password">Hasło</label>
              </div>

              <button type="submit" class="btn btn-primary btn-block mb-4">Zaloguj</button>

              <div class="text-center">
                <p>Nie masz konta? <a href="rejestracja_pacjenta.php">Zarejestruj się</a></p>
              </div>
              <div class="text-center" id="info" style="font-weight: bold; color: red;">
                 
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>