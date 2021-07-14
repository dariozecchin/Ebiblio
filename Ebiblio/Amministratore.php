<?php
session_start();

$db = mysqli_connect('localhost','root','','EBIBLIO') or die("Non è stato possibile connetersi al DB");


if ( isset($_SESSION['account'])) {
  if ($_SESSION['account'] != 'Amministratore'){
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
  <title>Amministratore</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styleUtili.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navOverride">
  <a class="navbar-brand" href="Amministratore.php">Ebiblio</a>
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
    <li class="list-group-item"><a href = "#sez11">LIBRO</a></li>
    <li class="list-group-item"><a href = "#sez2">PRENOTAZIONE</a></li>
    <li class="list-group-item"><a href = "#sez3">BACHECA</a></li>

</ul>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!--LIBRO-->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 1 = Inserimento di un libro-->
<!--CatalogaLibro-->
<div class="col-md-8">
<form action = "Amm.php" method = "post">

  <h1>AMMINISTRATORE</h1>
  <hr>
  <br>

  <h2><a name = "sez1">LIBRO</a></n2>
  <br>
    <h3><a name = "stored1">Cataloga libro</a></h3>

    <input type = "hidden" name = "numero" id = "numero" value = "1">

    <p>Inserire il titolo</p>
    <input type = "text" name = "inputTitolo1" id = "inputTitolo1" required>

    <p>Inserire autori</p>
    <input type = "text" name = "inputAutori1" id = "inputAutori1" required>

    <p>Inserire genere</p>
    <input type = "text" name = "inputGenere1" id = "inputGenere1" required>

    <p>Inserire edizione</p>
    <input type = "text" name = "inputEdizione1" id = "inputEdizione1" required>

    <p>Inserire Anno</p>
    <input type = "number" name = "inputAnno1" id = "inputAnno1" required>
    <br><br>
    Inserisci lo stato di conservazione:
    <br>
    <select class="form-select" aria-label="Default select example" name = "inputStato1" id = "inputStato1" required>
       <option selected value="Ottimo">Ottimo</option>
        <option value="Buono">Buono</option>
        <option value="Non Buono">Non Buono</option>
        <option value="Scadente">Scadente</option>
    </select>
    <br>

    <br>
    Inserire stato del prestito:
    <br>
    <select class="form-select" aria-label="Default select example" name = "inputPrestito1" id = "inputPrestito1" required>
       <option selected value="Disponibile">Disponibile</option>
        <option value="Prenotato">Prenotato</option>
        <option value="Consegnato">Consegnato</option>
    </select>
    <br>


    <p>Inserire numero pagine del libro</p>
    <input type = "number" name = "inputPagine1" id = "inputPagine1" required>

    <p>Inserire numero scaffale</p>
    <input type = "number" name = "inputScaffale1" id = "inputScaffale1" required>

    <?php
    $option="";
     $queryNBiblio="SELECT Nome FROM BIBLIOTECA";
      $resultNBiblio = mysqli_query($db,$queryNBiblio);

      foreach ($resultNBiblio as $row) {
        $nomeB = $row['Nome'];
        $option.='<option value="'.$nomeB.'">'.$nomeB.'</option>';
      }

    ?>
<br> <br>
    <select class="form-select" aria-label="Default select example" name = "inputBiblioteca1" id = "inputBiblioteca1" required>


       <?php
       echo $option;
       ?>
    </select>


    <br>
    <br>

    <button type = "submit" name = "button" class="btn btn-primary"> Inserisci</button>
    <br>
    <hr>
</form>

</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 2 = Cancellazione di un libro-->
<!--EliminaLibro-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Amm.php" method = "post">
        <h3><a name = "stored2">Rimuovi libro</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "2">

        <p>Inserire il codice del libro da elimianre</p>
        <input type = "number" name = "inputCodice2" id = "inputCodice2" required>

        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Elimina</button>
        <br>
        <hr>
    </form>

  </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 3 = Aggiornamento libro-->
<!--AggiornamentoLibro-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Amm.php" method = "post">
        <h3><a name = "stored3">Modifico libro</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "3">

        <p>Inserire il codice del libro da aggiornare</p>
        <input type = "number" name = "inputCodice3" id = "inputCodice3" required>

        <p>Inserire il titolo</p>
        <input type = "text" name = "inputTitolo3" id = "inputTitolo3" required>

        <p>Inserire autori</p>
        <input type = "text" name = "inputAutori3" id = "inputAutori3" required>

        <p>Inserire genere</p>
        <input type = "text" name = "inputGenere3" id = "inputGenere3" required>

        <p>Inserire edizione</p>
        <input type = "text" name = "inputEdizione3" id = "inputEdizione3" required>

        <p>Inserire Anno</p>
        <input type = "number" name = "inputAnno3" id = "inputAnno3" required>


        <br><br>
        Inserisci lo stato di conservazione:
        <br>
        <select class="form-select" aria-label="Default select example" name = "inputStato3" id = "inputStato3" required>
           <option selected value="Ottimo">Ottimo</option>
            <option value="Buono">Buono</option>
            <option value="Non Buono">Non Buono</option>
            <option value="Scadente">Scadente</option>
        </select>
        <br>

        <br>
        Inserire stato del prestito:
        <br>
        <select class="form-select" aria-label="Default select example" name = "inputPrestito3" id = "inputPrestito3" required>
           <option selected value="Disponibile">Disponibile</option>
            <option value="Prenotato">Prenotato</option>
            <option value="Consegnato">Consegnato</option>
        </select>
        <br>

        <p>Inserire numero pagine del libro</p>
        <input type = "number" name = "inputPagine3" id = "inputPagine3" required>

        <p>Inserire numero scaffale</p>
        <input type = "number" name = "inputScaffale3" id = "inputScaffale3" required>

        <br><br>
        <select class="form-select" aria-label="Default select example" name = "inputBiblioteca3" id = "inputBiblioteca3" required>


           <?php
           echo $option;
           ?>
        </select>


        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Modifica </button>
        <br>
        <hr>
        <br>
    </form>

  </div>
</div>




<!---------------------------------------------------------------------------------------------------------------------------------->
<!--PRENOTAZIONE-->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 8 = Visualizzazione di prenotazione dei libri attivi-->
<!--PrenotazioniLibriAmministratoreAttive-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
    <form action = "Amm.php" method = "post">

      <h2><a name = "sez2">PRENOTAZIONE</a></n2>
      <br>

        <h3>Prenotazioni di libri in corso</h3>

        <input type = "hidden" name = "numero" id = "numero" value = "8">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza</button>
        <br>
        <hr>
    </form>

  </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 10 = Visualizzazione di prenotazione dei libri attivi-->
<!--PostiBibliotecaAttivi-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Amm.php" method = "post">
        <h3>Prenotazioni di posti in corso</h3>

        <input type = "hidden" name = "numero" id = "numero" value = "10">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza</button>
        <br>
        <hr>
    </form>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 4 = Visualizzazione di tutte le prenotazioni biblioteca-->
<!--PrenotazioneBiblioteca-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Amm.php" method = "post">
        <h3><a name = "stored4">Storico libri prenotati</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "4">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza</button>
        <br>
        <hr>
    </form>

  </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 9 = Visualizzare i posti prenotati della tua biblioteca-->
<!--PostiBibliotecaStorico-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Amm.php" method = "post">
        <h3><a name = "stored9">Storico posti prenotati</a> </h3>

        <input type = "hidden" name = "numero" id = "numero" value = "9">

        <button type = "submit" name = "button" class="btn btn-primary"> Visualizza</button>
        <br>
        <hr>
        <br>
    </form>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--BACHECA-->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 5 = Inserimento di una messaggio-->
<!--MandaMessaggio-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
  <form action = "Amm.php" method = "post">

    <h2><a name = "sez3">BACHECA</a></n2>
    <br>

      <h3><a name = "stored5">Invia un messaggio</a></h3>

      <input type = "hidden" name = "numero" id = "numero" value = "5">

      <p>Inserire il titolo</p>
      <input type = "text" name = "inputTitolo5" id = "inputTitolo5" required>

      <p>Inserire il testo del messaggio</p>
      <input type = "text" name = "inputMessaggio5" id = "inputMessaggio5" required>


      <p>Inserire email del destinatario</p>
      <input type = "email" name = "inputEmailU5" id = "inputEmailU5" required>

      <br>
      <br>

      <button type = "submit" name = "button" class="btn btn-primary"> Invia </button>
      <br>
      <hr>
    </form>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 6 = Inserimento di una segnalazione-->
<!--InviaSegnalazione-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Amm.php" method = "post">
        <h3><a name = "stored6"> Invia una segnalazione </a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "6">

        <p>Inserire email del destinatario</p>
        <input type = "email" name = "inputEmailU6" id = "inputEmailU6" required>

        <p>Inserire il testo del messaggio</p>
        <input type = "text" name = "inputTesto6" id = "inputTesto6" required>


        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Invia </button>
        <br>
        <hr>
    </form>

  </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--STORED 7 = Cancella le segnalazioni ad un utente -->
<!--RimuoviSegnalazione-->
<div class="row">
<div class="col-6 col-md-4"></div>
 <div class="col-md-8">
<form action = "Amm.php" method = "post">
        <h3><a name = "stored7">Rimuovi le segnalazioni di un utente</a></h3>

        <input type = "hidden" name = "numero" id = "numero" value = "7">

        <p>Inserire email del destinatario</p>
        <input type = "email" name = "inputEmailU7" id = "inputEmailU7" required>

        <br>
        <br>

        <button type = "submit" name = "button" class="btn btn-primary"> Elimina</button>
        <br>
        <hr>
    </form>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------->

</div>
</body>
</html>
