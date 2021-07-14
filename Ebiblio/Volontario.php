<?php
session_start();


if ( isset($_SESSION['account'])) {
  if ($_SESSION['account'] != 'Volontario'){
     session_unset();
      header("location:login.php");
      exit;
    }

}
else {
  header("location:login.php");
}



    ?>

<html>
    <head>
      <title>Volontario</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/styleUtili.css">

    </head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navOverride">
  <a class="navbar-brand" href="Volontario.php">Ebiblio</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="Informazioni.php">Informazioni<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Statistiche.php">Statistiche</a>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php

      if ( !isset($_SESSION["loggedin"]) && !isset($_SESSION["email"])){ ?>




      <div class="nav-registersection">
      <li><a href="login.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
  </svg> Accedi/Registati</a></li>
    </div>
  <?php }
  else{

    ?>
    <li class="nav-item" id="logoutid">
      <a class="nav-link" href="#"><form method="post">
      <input type="submit" name="logout" id="logout" value="LOG OUT"  class="btn btn-secondary"/><br/>
      </form></a>
    </li>

  <li id="emailId">
  <div class="namelog" id="logName">
  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-person" viewBox="0 0 16 12">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
  </svg><?php echo $_SESSION['email']; ?>
  </li>
  </div>
  <?php } ?>



    </ul>
  </div>
  </nav>
  <?php
  // clear all the session variables and redirect to index
  function logOut()
  {
     session_unset();
     header("location: login.php");
     exit;
  }

  if(array_key_exists('logout',$_POST)){
     logout();

  }

  ?>




<div class="container" id="contId">
  <div class="row" id="primaRiga">
    <div class="col-6 col-md-4">
<ul class="list-group">
    <li class="list-group-item" ><a href = "#stored5">Consegne attive</a></li>
    <li class="list-group-item"><a href = "#stored1">Storico consegne</a></li>
</ul>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 5 = Visualizzazione tutte le consegne che posso fare-->
<!--ConsegneDisponibili-->

 <div class="col-md-8">
<form action = "Vol.php" method = "post">

    <h1>VOLONTARIO</h1>
    <hr>
    <br>

        <h3><a name=#stored5>Consegne disponibili</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "5">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
        <br>
        <hr>
    </form>
  </div>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 2 = INSERISCI UN NUOVO EVENTO DI CONSEGNA-->
<!--NuovoEvento-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Vol.php" method = "post">
    <h3><a name = "stored2">Nuova consegna</a></h3>

    <input type = "hidden" name = "numero" id = "numero" value = "2">

    <p>Inserire codice prenotazione</p>
    <input type = "number" name = "inputCodice2" id = "inputCodice2" required>


    <p>Inserire la data di prenotazione</p>
    <input type = "date" name = "inputData2" id = "inputData2" required>


    <br>


<br>
    <p>Inserire, se possibile, delle note</p>
    <input type = "text" name = "inputNote2" id = "inputNote2">

    <br>
    <br>

    <button type = "submit" name = "button" class="btn btn-primary"> Inserisci</button>
    <br>
    <hr>
</form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 4 = Visualizzazione di tutte le prenotazioni attive-->
<!--PrenotazioniVolAttive-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Vol.php" method = "post">
    <h3><a name = "stored4">Consegne da effettuare</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "4">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
        <br>
        <hr>
    </form>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 3 = UPDATE EVENTO-->
<!--AggiornamentoEventoConsegna-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Vol.php" method = "post">
    <h3><a name = "stored3">Modifica consegna</a></h3>
    <input type = "hidden" name = "numero" id = "numero" value = "3">

    <p>Inserire codice prenotazione della consegna che si vuole modificare</p>
    <input type = "number" name = "inputCodice3" id = "inputCodice3" required>

    <br>

    Inserisci il tipo della consegna che si vuole modificare:
    <br><br>
    <select class="form-select" aria-label="Default select example" name = "inputTipo3" id = "inputTipo3">
      <option value="Affidamento">Affidamento</option>
      <option selected value="Restituzione">Restituzione</option>
        
    </select>
    <br>

    <p>Inserire la data di prenotazione</p>
    <input type = "date" name = "inputData3" id = "inputData3" required>

  
    <br>
    
    <p>Inserire, se possibile, delle note</p>
    <input type = "text" name = "inputNote3" id = "inputNote3">

    <br>
    <br>

     <button type = "submit" name = "button" class="btn btn-primary"> Modifica</button>
    <br>
    <hr>
</form>
</div>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 1 = Visualizzazione di tutte le prenotazioni-->
<!--PrenotazioniTotaliVolontario-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Vol.php" method = "post">

        <h3><a name = "stored1">Storico consegne</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "1">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza</button>
        <br>
    </form>
  </div>
</div>




<!---------------------------------------------------------------------------------------------------------------------------------->



</div>
</body>
</html>
