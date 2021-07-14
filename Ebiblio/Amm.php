<!--VisualizzaBiblioteche-->
<?php
session_start();


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
    <head><title>Amm.php</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/styleUtenti.css">
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
      <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
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


      <div class="container" id="conteinUtente">
    <form action = "Amm.php" method = "post">
    <!---------------------------------------------------------------------------------------------------------------------------------->
    <?php

    $db = mysqli_connect('localhost','root','','EBIBLIO') or die("Non è stato possibile connetersi al DB");
    $numero = $_REQUEST['numero'];
    //---------------------------------------------------------------------------------------------------------------------------------------
    if($numero == 1){
        $email1 = $_SESSION['email'];

        echo("<h2>INSERIMENTO LIBRO</h2>");
        $titolo1 = mysqli_real_escape_string($db, $_REQUEST['inputTitolo1']);
        $autori1 = mysqli_real_escape_string($db, $_REQUEST['inputAutori1']);
        $genere1 = mysqli_real_escape_string($db, $_REQUEST['inputGenere1']);
        $edizione1 = mysqli_real_escape_string($db, $_REQUEST['inputEdizione1']);
        $anno1 = $_REQUEST['inputAnno1'];
        $stato1 = mysqli_real_escape_string($db, $_REQUEST['inputStato1']);
        $prestito1 = mysqli_real_escape_string($db, $_REQUEST['inputPrestito1']);
        $pagine1 = $_REQUEST['inputPagine1'];
        $scaffale1 = $_REQUEST['inputScaffale1'];
        $biblioteca1 = mysqli_real_escape_string($db, $_REQUEST['inputBiblioteca1']);

        //TRY E CATCH
        $CL_query  = "CALL CatalogaLibro('$titolo1', '$autori1','$genere1','$edizione1', '$anno1', '$stato1', '$prestito1', '$pagine1', '$scaffale1','$email1')";
        $CL_result = mysqli_query($db,$CL_query);
        $varCount1 = mysqli_affected_rows($db);

        if ($varCount1<=0) {
          echo("<br>");
          echo("L'inserimento non è riuscito");
        }
        else {
          echo("<br>");
          echo("Il libro è stato catalogato con successo");

          //insert nel log di mongodb
          if ( extension_loaded("mongodb")){

            try {
            $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query([]);
            $cursor = $manager -> executeQuery("Ebiblio.Log", $query);

            $bulk = new MongoDB\Driver\BulkWrite;
            $doc = [ 'log' => 'Inserito un cartaceo da '.$email1 ];
            $bulk->insert($doc);
            $result = $manager->executeBulkWrite('Ebiblio.Log', $bulk);

            }catch(MongoConnectionException $e){
            var_dump($e);
            }
          }
        }
      }

    //---------------------------------------------------------------------------------------------------------------------------------------
    if($numero == 2){
        echo("<h2>ELIMINAZIONE</h2>");
        $codice2 = $_REQUEST['inputCodice2'];
        $EL_query  = "CALL EliminaLibro('$codice2')";
        $EL_result = mysqli_query($db,$EL_query);
        $varCount2 = mysqli_affected_rows($db);

        if ($varCount2<=0) {
          echo("<br>");
          echo("Il libro inserito non è presente nel catalogo");
        }
        else{
          echo("<br>");
          echo("Il libro è stato eliminato con successo");
        }

    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    if($numero == 3){
        echo("<h2>MODIFICO LIBRO</h2>");
        $codice3 = $_REQUEST['inputCodice3'];
        $titolo3 = mysqli_real_escape_string($db, $_REQUEST['inputTitolo3']);
        $autori3 = mysqli_real_escape_string($db, $_REQUEST['inputAutori3']);
        $genere3 = mysqli_real_escape_string($db, $_REQUEST['inputGenere3']);
        $edizione3 = mysqli_real_escape_string($db, $_REQUEST['inputEdizione3']);
        $anno3 = $_REQUEST['inputAnno3'];
        $stato3 = mysqli_real_escape_string($db, $_REQUEST['inputStato3']);
        $prestito3 = mysqli_real_escape_string($db, $_REQUEST['inputPrestito3']);
        $pagine3 = $_REQUEST['inputPagine3'];
        $scaffale3 = $_REQUEST['inputScaffale3'];
        $biblioteca3 = mysqli_real_escape_string($db, $_REQUEST['inputBiblioteca3']);

        $AL_query  = "CALL AggiornamentoLibro('$codice3','$titolo3','$autori3','$genere3','$edizione3', '$anno3', '$stato3', '$prestito3', '$pagine3', '$scaffale3', '$biblioteca3')";
        $AL_result = mysqli_query($db,$AL_query);
        $varCount3 = mysqli_affected_rows($db);

        if ($varCount3<=0) {
          echo("<br>");
          echo("Non è stato possibile modificare il libro inserito");
        }
        else {
          echo("<br>");
          echo("Il libro è stato modificato con successo");
        }

    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    if($numero == 4){
        echo("<h2>PRENOTAZIONI DELLA BIBLIOTECA</h2>");
        $email4 = $_SESSION['email'];

        $PB_query  = "CALL PrenotazioneBiblioteca('$email4')";
        $PB_result = mysqli_query($db,$PB_query);
        $varCount4 = mysqli_affected_rows($db);

        if ($varCount4<=0) {
          echo("Non sono ancora stati prenotati libri nella tua biblioteca");
        }

        foreach($PB_result as $row){
            echo "<br>";
            echo("Codice prenotazione : ".$row['Codice']);
            echo "<br>";
            echo("Data : ".$row['DataAvvio']. " / ". $row['DataFine']);
            echo "<br>";
            echo("Codice libro : ".$row['CodiceCartaceo']);
            echo "<br>";
            echo("Email utilizzatore : ".$row['EmailUtilizzatore']);
            echo("<hr>");
        }
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    if($numero == 5){
        echo("<h2>INSERIMENTO MESSAGGIO</h2>");
        $titolo5 = mysqli_real_escape_string($db, $_REQUEST['inputTitolo5']);
        $testo5 = mysqli_real_escape_string($db, $_REQUEST['inputMessaggio5']);
        $data5 = date("Y-m-d"); //data di oggi perchè quando si inserisci il mex la data deve essere sempre odierna.
        $email5 = $_SESSION['email'];
        $emailU5 = mysqli_real_escape_string($db, $_REQUEST['inputEmailU5']);

        $MM_query  = "CALL MandaMessaggio('$titolo5','$testo5','$data5','$email5','$emailU5')";
        $MM_result = mysqli_query($db,$MM_query);
        $varCount5 = mysqli_affected_rows($db);

        if ($varCount5<=0) {
          echo("<br>");
          echo("Non è stato possibile inviare il messaggio");
        }
        else {
          echo("<br>");
          echo("Il messaggio è stato inviato con successo");

          //insert nel log di mongodb
          if ( extension_loaded("mongodb")){

            try {
            $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query([]);
            $cursor = $manager -> executeQuery("Ebiblio.Log", $query);

            $bulk = new MongoDB\Driver\BulkWrite;
            $doc = [ 'log' => 'Inserito un messaggio da '.$email5 ];
            $bulk->insert($doc);
            $result = $manager->executeBulkWrite('Ebiblio.Log', $bulk);

            }catch(MongoConnectionException $e){
            var_dump($e);
            }
          }
        }
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    if($numero == 6){
        echo("<h2>INSERIMENTO SEGNALAZIONE</h2>");

        $emailU6 = mysqli_real_escape_string($db, $_REQUEST['inputEmailU6']);
        $testo6 = mysqli_real_escape_string($db, $_REQUEST['inputTesto6']);
        $email6 =$_SESSION['email'];

        $IS_query  = "CALL InviaSegnalazione('$emailU6','$testo6','$email6')";
        $IS_result = mysqli_query($db,$IS_query);
        $varCount6 = mysqli_affected_rows($db);

        if ($varCount6<=0) {
          echo("<br>");
          echo("Non è stato possibile inviare la segnalazione");
        }
        else {
          echo("<br>");
          echo("La segnalazione è stata inviata con successo");

          //insert nel log di mongodb
          if ( extension_loaded("mongodb")){

            try {
            $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query([]);
            $cursor = $manager -> executeQuery("Ebiblio.Log", $query);

            $bulk = new MongoDB\Driver\BulkWrite;
            $doc = [ 'log' => 'Inserito una segnalazione da '.$email6 ];
            $bulk->insert($doc);
            $result = $manager->executeBulkWrite('Ebiblio.Log', $bulk);

            }catch(MongoConnectionException $e){
            var_dump($e);
            }
          }
        }


    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    if($numero == 7){
        echo("<h2>ELIMINAZIONE SEGNALAZIONE</h2>");
        $emailU7 = mysqli_real_escape_string($db, $_REQUEST['inputEmailU7']);

        $RS_query  = "CALL RimuoviSegnalazione('$emailU7')";
        $RS_result = mysqli_query($db,$RS_query);
        $varCount7 = mysqli_affected_rows($db);

        if ($varCount7<=0) {
          echo("<br>");
          echo("Non è stato possibile eliminare le segnalazioni dell'utente");
        }
        else {
          echo("<br>");
          echo("Sono state rimosse le segnalazioni relative all'utente");
        }


    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    if($numero == 8){
        echo("<h2>LIBRI PRENOTATI</h2>");
        $email8 = $_SESSION['email'];

        $PLAA_query  = "CALL PrenotazioniLibriAmministratoreAttive('$email8')";
        $PLAA_result = mysqli_query($db,$PLAA_query);
        $varCount8 = mysqli_affected_rows($db);

        if ($varCount8<=0) {
          echo("Non ci sono prenotazioni in corso al momento");
        }

        foreach($PLAA_result as $row){
            echo "<br>";
            echo("Codice prenotazione : ".$row['Codice']);
            echo "<br>";
            echo("Data : ".$row['DataAvvio']. " / ". $row['DataFine']);
            echo "<br>";
            echo("Codice libro : ".$row['CodiceCartaceo']);
            echo "<br>";
            echo("Email utilizzatore : ".$row['EmailUtilizzatore']);
            echo("<hr>");
        }
    }
     //---------------------------------------------------------------------------------------------------------------------------------------
     if($numero == 9){
        echo("<h2>POSTI PRENOTATI</h2>");
        $email9 = $_SESSION['email'];

        $PBS_query  = "CALL PostiBibliotecaStorico('$email9')";
        $PBS_result = mysqli_query($db,$PBS_query);
        $varCount9 = mysqli_affected_rows($db);

        if ($varCount9<=0) {
          echo("Non sono ancora stati prenotati dei posti lettura nella sua biblioteca");
        }

        foreach($PBS_result as $row){
            echo "<br>";
            echo("Nome biblioteca : ".$row['NomeBibliotecaPostoLettura']);
            echo "<br>";
            echo("Numero posto : ".$row['NumeroPostoLettura']);
            echo "<br>";
            echo("Email dell'utilizzatore : ".$row['EmailUtilizzatore']);
            echo "<br>";
            echo("Data : ".$row['DataPrenotazione']);
            echo "<br>";
            echo("Ora : ".$row['OraInizio']. "-".$row['OraFine']);
            echo("<hr>");
        }
    }
     //---------------------------------------------------------------------------------------------------------------------------------------
     if($numero == 10){
        echo("<h2>POSTI PRENOTATI ATTIVI</h2>");
        $email10 = $_SESSION['email'];

        //TRY E CATCH
        $PBA_query  = "CALL PostiBibliotecaAttivi('$email10')";
        $PBA_result = mysqli_query($db,$PBA_query);
        $varCount10 = mysqli_affected_rows($db);

        if ($varCount10<=0) {
          echo("Non ci sono prenotazioni in corso al momento");
        }


        foreach($PBA_result as $row){
            echo "<br>";
            echo("Nome biblioteca : ".$row['Biblioteca']);
            echo "<br>";
            echo("Numero posto : ".$row['NumeroPosto']);
            echo "<br>";
            echo("Email dell'utilizzatore : ".$row['EmailUtilizzatore']);
            echo "<br>";
            echo("Data : ".$row['DataPrenotazione']);
            echo "<br>";
            echo("Ora : ".$row['OraInizio']. "-".$row['OraFine']);
            echo("<hr>");
        }
    }
    ?>
    <br>
    <!--LINK PER TORNARE ALLA HOMEPAGE-->
    <a href = "Amministratore.php">Vuoi tornare alla homepage? Cliccami</a>
    </form>


</div>
</body>
</html>
