<!--VisualizzaBiblioteche-->
<?php

session_start();
if ( isset($_SESSION['account'])) {
  if ($_SESSION['account'] != 'Volontario'){
     session_unset();
      header("location:login.php");
      exit;
    }

}



    ?>
<html>
    <head><title>Vol</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/styleUtenti.css">
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
    <form action = "Vol.php" method = "post">
    <!---------------------------------------------------------------------------------------------------------------------------------->
    <?php

    $db = mysqli_connect('localhost','root','','ebiblio') or die("Non è stato possibile connetersi al DB");
    $numero = $_REQUEST['numero'];
    //----------------------------------------------------------------------------------------------------------------------------------
    //Non c'è bisogna di modificare
    if($numero == 1){
        echo("<h2>STORICO CONSEGNE</h2>");
        $email1 = $_SESSION['email'];
        $PTV_query  = "CALL PrenotazioniTotaliVolontario('$email1')";
        $PTV_result = mysqli_query($db,$PTV_query);
        $varCount1 = mysqli_affected_rows($db);

        if($varCount1 <= 0){
          echo("Non hai ancora effettuato nessuna consegna");
        }
        else {

        foreach($PTV_result as $row){
            echo "<br>";
            echo("Codice prenotazione : ".$row['CodicePrenotazioneLibro']);
            echo "<br>";
            echo("Data consegna : ".$row['DataConsegna']);
            echo "<br>";
            echo("Codice libro : ".$row['CodiceCartaceo']);
            echo "<br>";
            echo("Email utilizzatore : ".$row['EmailUtilizzatore']);
            echo "<br>";
            echo("Tipo : ".$row['Tipo']);
            echo "<br>";
            echo("Note : ".$row['Note']);
            echo("<hr>");
        }
      }
    }
    //----------------------------------------------------------------------------------------------------------------------------------

    if($numero == 2){
        echo("<h2>INSERIMENTO EVENTO</h2>");
        $codice2 = $_REQUEST['inputCodice2'];
        $email2 = $_SESSION['email'];
        $data2 = $_REQUEST['inputData2'];
        $note2 = $_REQUEST['inputNote2'];

        $NE_query  = "CALL NuovoEvento('$codice2', '$email2', '$data2', '$note2')";
        $NE_result = mysqli_query($db,$NE_query);
        $varCount2 = mysqli_affected_rows($db);

        if($varCount2 <= 0){
          echo("Non è possibile aggiungere un evento consegna per la prenotazione indicata");
        } else{
          echo("Hai appena aggiunto alla tua lista una nuova consegna");

          //insert nel log di mongodb
          if ( extension_loaded("mongodb")){

            try {
            $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query([]);
            $cursor = $manager -> executeQuery("Ebiblio.Log", $query);

            $bulk = new MongoDB\Driver\BulkWrite;
            $doc = [ 'log' => 'Inserita un evento di consegna da '.$email2 ];
            $bulk->insert($doc);
            $result = $manager->executeBulkWrite('Ebiblio.Log', $bulk);

            }catch(MongoConnectionException $e){
            var_dump($e);
            }
          }
        }
    }
    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 3){
        echo("<h2>MODIFICA EVENTO</h2>");
        $codice3 = $_REQUEST['inputCodice3'];
        $email3 = $_SESSION['email'];
        $data3 = $_REQUEST['inputData3'];
        $tipo3 = $_REQUEST['inputTipo3'];
        $note3 = $_REQUEST['inputNote3'];

        $AEC_query1  = "CALL AggiornamentoEventoConsegna('$codice3', '$email3', '$data3', '$tipo3', '$note3')";
        $AEC_results1 = mysqli_query($db,$AEC_query1);
        $varCount3 = mysqli_affected_rows($db);

        if($varCount3 <= 0){
          echo("Mi dispiace, ma non è possibile aggiornare l'evento consegna desiderato");
        } else {
          echo("Evento consegna aggiornato con successo");
        }
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 4){
        echo("<h2>CONSEGNE DA EFFETTUARE</h2>");
        $email4 = $_SESSION['email'];
        $PV_query  = "CALL PrenotazioniVolAttive('$email4')";
        $PV_result = mysqli_query($db,$PV_query);
        $varCount4 = mysqli_affected_rows($db);

        if($varCount4 <= 0){
          echo("Non ci sono consegne da effettuare");
        }

        foreach($PV_result as $row){
            echo "<br>";
            echo("Codice prenotazione : ".$row['CodicePrenotazioneLibro']);
            echo "<br>";
            echo("Data consegna : ".$row['DataConsegna']);
            echo "<br>";
            echo("Codice libro : ".$row['CodiceCartaceo']);
            echo "<br>";
            echo("Email utilizzatore : ".$row['EmailUtilizzatore']);
            echo "<br>";
            echo("Tipo : ".$row['Tipo']);
            echo "<br>";
            echo("Note : ".$row['Note']);
            echo("<hr>");
        }
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 5){

        echo("<h2>CONSEGNE DISPONIBILI</h2>");

        $stmt = $db->prepare("CALL ConsegneAffidamentoDisponibili()");
        $stmt->execute();
        $result1 = $stmt->get_result();
        while($row1 = $result1->fetch_assoc()) {
          echo "<br>";
            echo("Codice prenotazione : ".$row1['Codice']);
            echo "<br>";
            echo("Data: ".$row1['DataAvvio']."/".$row1['DataFine']);
            echo "<br>";
            echo("Codice libro : ".$row1['CodiceCartaceo']);
            echo "<br>";
            echo("Email utilizzatore : ".$row1['EmailUtilizzatore']);
            echo "<br>";
            echo("Tipo : Affidamento");
            echo "<br>";
            echo("<hr>");
        }
        $stmt->close();

        $stmt = $db->prepare("CALL ConsegneRestituzioneDisponibili()");
        $stmt->execute();
        $result2 = $stmt->get_result();
        while($row2 = $result2->fetch_assoc()) {
          echo "<br>";
          echo("Codice prenotazione : ".$row2['Codice']);
          echo "<br>";
          echo("Data: ".$row2['DataAvvio']."/".$row2['DataFine']);
          echo "<br>";
          echo("Codice libro : ".$row2['CodiceCartaceo']);
          echo "<br>";
          echo("Email utilizzatore : ".$row2['EmailUtilizzatore']);
          echo "<br>";
          echo("Tipo : Restituzione");
          echo "<br>";
          echo("<hr>");
        }
    }

    //----------------------------------------------------------------------------------------------------------------------------------

    ?>
    <br>
    <!--LINK PER TORNARE ALLA HOMEPAGE-->
    <a href = "Volontario.php">Vuoi tornare alla homepage? Cliccami</a>
    </form>



</div>
</body>
</html>
