<?php
session_start();
$db = mysqli_connect('localhost','root','','EBIBLIO') or die("Non è stato possibile connetersi al DB");

if ( isset($_SESSION['account'])) {
  if ($_SESSION['account'] != 'Utilizzatore'){
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
  <title>Utilizzatore</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styleUtili.css">
</head>
<body>


  <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navOverride">
  <a class="navbar-brand" href="Utilizzatore.php">Ebiblio</a>
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
  <!-- Stack the columns on mobile by making one full-width and the other half-width -->
  <div class="row" id="primaRiga">
    <div class="col-6 col-md-4">
<ul class="list-group">
    <li class="list-group-item"><a href = "#sez1">Posto lettura</a></li>
    <li class="list-group-item"><a href = "#sez2">Libro cartaceo</a></li>
    <li class="list-group-item" ><a href = "#sez3">Ebook</a></li>
    <li class="list-group-item" ><a href = "#sez4">Consegna</a></li>
    <li class="list-group-item" ><a href = "#sez5">Bacheca</a></li>


</ul>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!--POSTO LETTURA--->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 1 = Prenotazione posto-->
<!--PrenotaPosto-->
<?php
$option="";
 $queryNBiblio="SELECT Nome FROM BIBLIOTECA";
  $resultNBiblio = mysqli_query($db,$queryNBiblio);

  foreach ($resultNBiblio as $row) {
    $nomeB = $row['Nome'];
    $option.='<option value="'.$nomeB.'">'.$nomeB.'</option>';
  }

?>
 <div class="col-md-8">
<form action = "UtzzSQL.php" method = "post">

        <h1><a name = "sez1">UTILIZZATORE</a></h1>
        <hr>
        <br>

        <h2><a name = "sez1">POSTO LETTURA</a></h2>
        <br>

        <h3><a name = "stored1">Prenota un posto nella biblioteca che preferisci</a></h3>
        <br>

        <input type = "hidden" name = "numero" id = "numero" value = "1">

        <select class="form-select" aria-label="Default select example" name = "inputBiblioteca1" id = "inputBiblioteca1">
           <option selected>Seleziona la biblioteca</option>

           <?php
           echo $option;
           ?>
        </select>


        <p>Inserire data</p>
        <input type = "date" name = "inputData1" id = "inputData1" required>

        <p>Inserire orario di inizio prenotazione [ex:9:00]</p>
        <input type = "time" name = "inputOraI1" id = "inputOraI1" required>

        <p>Inserire orario di fine prenotazione [ex:11:00]</p>
        <input type = "time" name = "inputOraF1" id = "inputOraF1" required>

        <p>Inserire se si vuole la corrente nel proprio posto</p>
        True <input type= "radio" id= "inputCorrente1" name="inputCorrente1" value= "1" >
        <label for= "inputCorrente1">  </label>
        False <input type="radio" id="inputCorrente1" name="inputCorrente1" value= "0" >
        <label for= "inputCorrente1">  </label><br>

        <p>Inserire se si vuole la presa a internet nel proprio posto</p>
        True <input type="radio" id="inputInternet1" name="inputInternet1" value="1">
        <label for="inputInternet1"></label>
        False
        <input type="radio" id="inputInternet1" name="inputInternet1" value="0">
        <label for="inputInternet1"></label><br>

        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Prenota </button>

        <br>
        <hr>
    </form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
 <!--STORED 12 = Elimino posto prenotato-->
    <!--EliminaPrenotazionePosto-->
    <div class="row">
    <div class="col-6 col-md-4"></div>
    <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">
        <h3><a name = "stored12">Elimina posto prenotato</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "12">

        <select class="form-select" aria-label="Default select example" name = "inputBiblioteca12" id = "inputBiblioteca12">
           <option selected>Seleziona la biblioteca</option>

           <?php
           echo $option;
           ?>
        </select>

        <br>
        <br>
        <p>Inserire data</p>
        <input type = "date" name = "inputData12" id = "inputData12" required>
        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Elimina </button>

        <br>
        <hr>
    </form>
</div>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 8 = Prenotazioni posto attive-->
<!--PostiPrenotatiAttivi-->

<div class="row">
  <div class="col-6 col-md-4"></div>
   <div class="col-md-8">
<form action = "UtzzSQL.php" method = "post">
        <h3>Prenotazioni posto in corso</h3>

        <input type = "hidden" name = "numero" id = "numero" value = "8">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
        <br>
        <hr>
    </form>
</div>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
    <!--STORED 4 = Visualizzazione prenotazione posto-->
    <!--PostoPrenotatoUtilizzatore-->
    <div class="row">
      <div class="col-6 col-md-4"></div>
       <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">
        <h3><a name = "stored4">Storico dei posti prenotati </a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "4">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
        <br>
        <hr>
        <br>
    </form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->




<!---------------------------------------------------------------------------------------------------------------------------------->
<!--LIBRO--->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 17 = Visualizzare libro cartaceo direttamente dal nome-->
<!--LibroDalNome-->
<div class="row">
<div class="col-6 col-md-4"></div>
<div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">

        <h2><a name = "sez2">LIBRO CARTACEO</a></h2>
        <br>

<!--Ricerca-->

        <h3><a name = "stored17">Ricerca dal nome</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "17">

        <p>Inserire il nome del libro per visualizzare le sue informazioni</p>
        <input type = "text" name = "inputNome17" id = "inputNome17" required>

        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
        <br>
        <hr>
    </form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 19 = Visualizzare libri CARTACEI Disponibili-->
<!--LibriDisponibili-->
<div class="row">
  <div class="col-6 col-md-4"></div>
    <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">
        <h3><a name = "stored19">Libri disponibili</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "19">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>

        <br>
        <hr>
    </form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
    <!--STORED 15 = Visualizzare libri CARTACEI Disponibili di ogni biblioteca-->
    <!--LibriBiblioteca-->
    <div class="row">
    <div class="col-6 col-md-4"></div>
    <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">
        <h3><a name = "stored15">Catologo biblioteca</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "15">

        <select class="form-select" aria-label="Default select example" name = "inputBiblioteca15" id = "inputBiblioteca15">
           <option selected>Seleziona la biblioteca</option>

           <?php
           echo $option;
           ?>
        </select>

        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>

        <br>
        <hr>
    </form>
</div>
</div>


<!--Prenotazione--->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 2 = Prenotazione libro cartaceo-->
<!--PrenotazioneLibro-->
<div class="row">
  <div class="col-6 col-md-4"></div>
   <div class="col-md-8">
<form action = "UtzzSQL.php" method = "post">
    <h3><a name = "stored2">Prenota il libro che vuoi</a></h3>
    <br>

    <input type = "hidden" name = "numero" id = "numero" value = "2">

    <p>Inserire il codice del libro da prenotare</p>
    <input type = "number" name = "inputCodice2" id = "inputCodice2" required>

    <br>
    <br>

    <button type = "submit" name = "button" class="btn btn-primary"> Prenota </button>

    <br>
    <hr>
</form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 7 = Prenotazione libri attive-->
<!--PrenotazioniLibriAttive-->
<div class="row">
  <div class="col-6 col-md-4"></div>
   <div class="col-md-8">
<form action = "UtzzSQL.php" method = "post">
        <h3>Prenotazioni di libri in corso</h3>

        <input type = "hidden" name = "numero" id = "numero" value = "7">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
        <br>
        <hr>
    </form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
    <!--STORED 13 = Eliminare una prenotazione del libro-->
    <!--EliminaPrenotazioneLibro-->
    <div class="row">
    <div class="col-6 col-md-4"></div>
      <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">
        <h3><a name = "stored13">Elimino libro prenotato</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "13">

        <p>Inserire il codice della prenotazione da eliminare</p>
        <input type = "number" name = "inputCodice13" id = "inputCodice13" required>

        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Elimina</button>
        <br>
        <hr>
    </form>
</div>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 3 = Prenotazione libro utilizzatore-->
<!--PrenotazioniLibroUtilizzatore-->
<div class="row">
  <div class="col-6 col-md-4"></div>
   <div class="col-md-8">
<form action = "UtzzSQL.php" method = "post">
        <h3><a name = "stored3">Storico libri prenotati</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "3">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
        <br>
        <hr>
        <br>
    </form>
</div>
</div>


<!---------------------------------------------------------------------------------------------------------------------------------->
<!--EBOOK--->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 14 = Visualizzare ebook disponibili-->
<!--EbookDisponibili-->
<div class="row">
<div class="col-6 col-md-4"></div>
  <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">

      <h2><a name = "sez3">EBOOK</a></h2>
      <br>

      <h3><a name = "stored14">Ebook disponibili</a></h3>

      <input type = "hidden" name = "numero" id = "numero" value = "14">

      <button type = "submit" name = "button" class="btn btn-primary"> Visualizza</button>
      <br>
      <hr>

    </form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 5 = Visualizzare Ebook-->
<!--VisualizzaEbook-->
<div class="row">
<div class="col-6 col-md-4"></div>
  <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">
        <h3><a name = "stored5">Leggere un ebook</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "5">

        <p>Inserire il codice dell'Ebook</p>
        <input type = "number" name = "inputCodice5" id = "inputCodice5" required>

        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza</button>
        <br>
        <hr>

    </form>
</div>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 16 = Visualizzare Ebook direttamente dal nome-->
<!--EbookDalNome-->
<div class="row">
<div class="col-6 col-md-4"></div>
<div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">
        <h3><a name = "stored16">Ricerca dal nome</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "16">

        <p>Inserire il nome dell'ebook per visualizzare le sue informazioni</p>
        <input type = "text" name = "inputNome16" id = "inputNome16" required>

        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
        <br>
        <hr>
        <br>
    </form>
</div>
</div>




<!---------------------------------------------------------------------------------------------------------------------------------->
<!--CONSEGNA--->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 9 = Eventi consegna attivi -->
<!--EventiConsegnaAttivi-->
<div class="row">
<div class="col-6 col-md-4"></div>
  <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">

    <h2><a name = "sez4">CONSEGNA</a></h2>
    <br>

        <h3>Consegne in corso</h3>

        <input type = "hidden" name = "numero" id = "numero" value = "9">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
        <br>
        <hr>
    </form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 18 = Cambia consegna utilizzatore-->
<!--CambiaConsegnaUtilizzatore-->
<div class="row">
<div class="col-6 col-md-4"></div>
<div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">
        <h3><a name = "stored18">Cambio data</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "18">

        <p>Inserire il codice dell'evento consegna</p>
        <input type = "number" name = "inputCodice18" id = "inputCodice18" required>

        <br>
        <br>

        <p>Inserire la nuova data per l'evento consegna</p>
        <input type = "date" name = "inputData18" id = "inputData18" required>

        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Modifica </button>
        <br>
        <hr>
    </form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
    <!--STORED 6 = Visualizzare propri eventi di consegna-->
    <!--EventiConsegnaUtilizzatore-->
    <div class="row">
      <div class="col-6 col-md-4"></div>
       <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">
         <h3><a name = "stored6">Storico consegne</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "6">


        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza</button>
        <br>
        <hr>
        <br>
    </form>
</div>
</div>




<!---------------------------------------------------------------------------------------------------------------------------------->
<!--BACHECA--->
<!---------------------------------------------------------------------------------------------------------------------------------->
 <!--STORED 11 = Visualizzare messaggi-->
    <!--MessaggiRicevuti-->
    <div class="row">
    <div class="col-6 col-md-4"></div>
    <div class="col-md-8">
    <form action = "UtzzSQL.php" method = "post">

    <h1><a name = "sez5">BACHECA</a></h1>
    <br>

      <h3><a name = "stored11">Messaggi ricevuti</a></h3>

      <input type = "hidden" name = "numero" id = "numero" value = "11">

      <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
      <br>
      <hr>

    </form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 10 = Visualizzare le segnalazioni che si sono ricevute-->
<!--SegnalazioniRicevute-->
<div class="row">
<div class="col-6 col-md-4"></div>
<div class="col-md-8">
<form action = "UtzzSQL.php" method = "post">
<h3><a name = "stored10">Segnalazioni ricevute</a></h3>

  <input type = "hidden" name = "numero" id = "numero" value = "10">

  <button type = "submit" name = "button" class="btn btn-primary"> Visualizza </button>
      <br>
      <hr>
</form>
</div>
</div>



<!---------------------------------------------------------------------------------------------------------------------------------->
</div>
</body>
</html>
