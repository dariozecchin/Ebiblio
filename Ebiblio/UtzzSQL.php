<!--VisualizzaBiblioteche-->
<?php

session_start();
if ( isset($_SESSION['account'])) {
    if ($_SESSION['account'] != 'Utilizzatore'){
       session_unset();
        header("location:login.php");
        exit;
      }

  }



?>
<html>
    <head><title>UtzzSQL</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/styleUtenti.css">
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
    <form action = "UtzzSQL.php" method = "post">
    <!---------------------------------------------------------------------------------------------------------------------------------->
    <?php
    $db = mysqli_connect('localhost','root','','EBIBLIO') or die("Non è stato possibile connetersi al DB");
    $numero = $_REQUEST['numero'];
    //----------------------------------------------------------------------------------------------------------------------------------


    if($numero == 1){
        echo("<h2>PRENOTAZIONE</h2>");
        $biblioteca1 = mysqli_real_escape_string($db, $_REQUEST['inputBiblioteca1']);
        $email1 = $_SESSION['email'];
        $data1 = $_REQUEST['inputData1'];
        $tempoI1 = $_REQUEST['inputOraI1'];
        $tempoF1 = $_REQUEST['inputOraF1'];
        $corrente1 = $_REQUEST['inputCorrente1'];
        $internet1 = $_REQUEST['inputInternet1'];

        $PP1_query  = "CALL PrenotaPosto('$biblioteca1','$email1','$data1','$tempoI1','$tempoF1','$corrente1','$internet1')";
        $PP1_result = mysqli_query($db,$PP1_query);
        $varCount1 = mysqli_affected_rows($db);

        if($varCount1 <= 0){
            echo("La prenotazione non è riuscita. Riprovare con dati diversi");
        } else {
            echo("Prenotazione avvenuta con successo");

            //insert nel log di mongodb
            if ( extension_loaded("mongodb")){

                try {
                $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                $query = new MongoDB\Driver\Query([]);
                $cursor = $manager -> executeQuery("Ebiblio.Log", $query);

                $bulk = new MongoDB\Driver\BulkWrite;
                $doc = [ 'log' => 'Inserita una prenotazione posto di lettura da '.$email1 ];
                $bulk->insert($doc);
                $result = $manager->executeBulkWrite('Ebiblio.Log', $bulk);

                }catch(MongoConnectionException $e){
                var_dump($e);
                }
              }

        }


    }

    //----------------------------------------------------------------------------------------------------------------------------------

    if($numero == 2){
        echo("<h2>PRENOTAZIONE</h2>");
        $codice2 = $_REQUEST['inputCodice2'];
        $emailU2 = $_SESSION['email'];

        $PL_query  = "CALL PrenotaLibro('$codice2', '$emailU2')";
        $PL_result = mysqli_query($db,$PL_query);
        $varCount2 = mysqli_affected_rows($db);

        if($varCount2 <= 0){
            echo("Non è possibile prenotare il libro selezionato. Riprovare con un altro codice");
        } else {
            echo("La prenotazione è avvenuta con successo");

            //insert nel log di mongodb
            if ( extension_loaded("mongodb")){

                try {
                $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                $query = new MongoDB\Driver\Query([]);
                $cursor = $manager -> executeQuery("Ebiblio.Log", $query);

                $bulk = new MongoDB\Driver\BulkWrite;
                $doc = [ 'log' => 'Inserita una prenotazione libro da '.$emailU2 ];
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
        echo("<h2>STORICO LIBRI PRENOTATI</h2>");
        $emailU3 = $_SESSION['email'];
        $PLU_query = "CALL PrenotazioniLibroUtilizzatore('$emailU3')";
        $PLU_result = mysqli_query($db,$PLU_query);
        $varCount3 = mysqli_affected_rows($db);


        if($varCount3 <= 0){
            echo("Non hai mai prenotato dei libri");
        }

        foreach($PLU_result as $row){
            echo "<br>";
            echo("Codice prenotazione : ".$row['Codice']);
            echo "<br>";
            echo("Data fine : ".$row['DataFine']);
            echo "<br>";
            echo("Codice libro : ".$row['CodiceCartaceo']);
            echo("<hr>");
        }
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 4){
        echo("<h2>STORICO POSTI PRENOTATI</h2>");
        $emailU4 = $_SESSION['email'];
        $PPU_query = "CALL PostoPrenotatoUtilizzatore('$emailU4')";
        $PPU_result = mysqli_query($db,$PPU_query);
        $varCount4 = mysqli_affected_rows($db);


        if($varCount4 <= 0){
            echo("Non hai mai prenotato dei posti lettura");
        }

        foreach($PPU_result as $row){
            echo "<br>";
            echo("Biblioteca : ".$row['NomeBibliotecaPostoLettura']);
            echo "<br>";
            echo("Numero posto : ".$row['NumeroPostoLettura']);
            echo "<br>";
            echo("Data : ".$row['DataPrenotazione']);
            echo "<br>";
            echo("Ora : ".$row['OraInizio']. "-". $row['OraFine']);
            echo("<hr>");
        }
    }
    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 5){
        $emailU5 = $_SESSION['email'];
        $codice5 = $_REQUEST['inputCodice5'];
        echo(" <h2>EBOOK NUMERO: $codice5  </h2> ");
        $VE_query = "CALL VisualizzaEbook('$codice5','$emailU5')";
        $VE_result = mysqli_query($db,$VE_query);
        $varCount5 = mysqli_affected_rows($db);

        if($varCount5 <= 0){
            echo("Il codice che hai digitato non corrisponde a nessun e-book");
        }
        else {
            //insert nel log di mongodb
            if ( extension_loaded("mongodb")){

                try {
                $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                $query = new MongoDB\Driver\Query([]);
                $cursor = $manager -> executeQuery("Ebiblio.Log", $query);

                $bulk = new MongoDB\Driver\BulkWrite;
                $doc = [ 'log' => 'Inserito un accesso ad un ebook da '.$emailU5 ];
                $bulk->insert($doc);
                $result = $manager->executeBulkWrite('Ebiblio.Log', $bulk);

                }catch(MongoConnectionException $e){
                var_dump($e);
                }
              }


        foreach($VE_result as $row){
            echo "<br>";
            echo("Titolo : ".$row['Titolo']);
            echo "<br>";
            echo("Autori: ".$row['ListaAutori']);
            echo "<br>";
            echo("Genere : ".$row['Genere']);
            echo "<br>";
            echo("Edizione : ".$row['NomeEdizione']);
            echo "<br>";
            echo("Anno : ".$row['AnnoPubblicazione']);
            echo "<br>";
            echo("PDF: <a href=\"DocumentazioneEbiblio.pdf\" target=\"_blank\"> ".$row['PDF']."</a>");
            echo "<br>";
            echo("NrAccessi : ".$row['NrAccessi']);
            echo "<br>";
            echo("Dimensione : ".$row['Dimensione']);
            echo("<hr>");
          }
        }
    }
    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 6){
        echo("<h2>STORICO DELLE CONSEGNE</h2>");
        $emailU6 =$_SESSION['email'];
        $ECU_query = "CALL EventiConsegnaUtilizzatore('$emailU6')";
        $ECU_result = mysqli_query($db,$ECU_query);
        $varCount6 = mysqli_affected_rows($db);


        if($varCount6 <= 0){
            echo("Non hai mai avuto consegne in questo portale");
        }

        foreach($ECU_result as $row){
            echo("Codice prenotazione : ".$row['CodicePrenotazioneLibro']);
            echo "<br>";
            echo("Email volontario : ".$row['EmailVolontario']);
            echo "<br>";
            echo("Data : ".$row['DataConsegna']);
            echo "<br>";
            echo("Tipo : ".$row['Tipo']);
            echo "<br>";
            echo("Note : ".$row['Note']);
            echo("<hr>");
        }
    }
    //----------------------------------------------------------------------------------------------------------------------------------

    if($numero == 7){
    echo("<h2>PRENOTAZIONI IN CORSO</h2>");
    $emailU7 = $_SESSION['email'];
    $PLA_query = "CALL PrenotazioniLibriAttive('$emailU7')";
    $PLA_result = mysqli_query($db,$PLA_query);
    $varCount7 = mysqli_affected_rows($db);

    if($varCount7 <= 0){
        echo("Non ci sono prenotazioni in corso");
    }

    foreach($PLA_result as $row){
        //solo 3 campi
        echo "<br>";
        echo("Codice prenotazione : ".$row['Codice']);
        echo "<br>";
        echo("Data fine : ".$row['DataFine']);
        echo "<br>";
        echo("Codice libro cartaceo : ".$row['CodiceCartaceo']);
        echo("<hr>");
        }
    }
    //----------------------------------------------------------------------------------------------------------------------------------

    if($numero == 8){
        echo("<h2>PRENOTAZIONI IN CORSO</h2>");
        $emailU8 = $_SESSION['email'];
        $PPA_query = "CALL PostiPrenotatiAttivi('$emailU8')";
        $PPA_result = mysqli_query($db,$PPA_query);
        $varCount8 = mysqli_affected_rows($db);

        if($varCount8 <= 0){
            echo("Non ci sono prenotazioni in corso");
        }

        foreach($PPA_result as $row){
            echo "<br>";
            echo("Nome biblioteca : ".$row['NomeBibliotecaPostoLettura']);
            echo "<br>";
            echo("Numero del posto prenotato : ".$row['NumeroPostoLettura']);
            echo "<br>";
            echo("Data : ".$row['DataPrenotazione']);
            echo "<br>";
            //CAMBIARE LA I MAIUSCOLA
            echo("Orario di prenotazione : ".$row['OraInizio']."-".$row['OraFine']);
            echo("<hr>");
            }
        }

    //----------------------------------------------------------------------------------------------------------------------------------

    if($numero == 9){
        echo("<h2>CONSEGNE IN CORSO</h2>");
        $emailU9 = $_SESSION['email'];
        $ECA_query = "CALL EventiConsegnaAttivi('$emailU9')";
        $ECA_result = mysqli_query($db,$ECA_query);
        $varCount9 = mysqli_affected_rows($db);

        if($varCount9 <= 0){
            echo("Non ci sono consegne in corso");
        }

        foreach($ECA_result as $row){
            echo "<br>";
            echo("Codice della prenotazione : ".$row['Codice']);
            echo "<br>";
            echo("Email volontario : ".$row['EmailVolontario']);
            echo "<br>";
            echo("Data consegna : ".$row['DataConsegna']);
            echo "<br>";
            echo("Tipo consegna : ".$row['Tipo']);
            echo "<br>";
            echo("Note : ".$row['Note']);
            echo("Codice della prenotazione del libro : ".$row['CodicePrenotazioneLibro']);
            echo("<br>");
            }
        }

    //----------------------------------------------------------------------------------------------------------------------------------

    if($numero == 10){
        echo("<h2>SEGNALAZIONI RICEVUTE</h2>");
        $emailU10 = $_SESSION['email'];
        $SR_query = "CALL SegnalazioniRicevute('$emailU10')";
        $SR_result = mysqli_query($db,$SR_query);
        $varCount10 = mysqli_affected_rows($db);

        if($varCount10 <= 0){
            echo("Non hai ricevuto nessuna segnalazione");
        }

        foreach($SR_result as $row){
            echo("Data : ".$row['DataSegnalazione']);
            echo "<br>";
            echo("Testo : ".$row['Testo']);
            echo "<br>";
            echo("Email amministratore : ".$row['EmailAmministratore']);
            echo("<hr>");
            }
        }
    //----------------------------------------------------------------------------------------------------------------------------------
        //STORED AGGIUNTA
        if($numero == 11){
            echo("<h2>MESSAGGI RICEVUTI</h2>");
            $emailU11 = $_SESSION['email'];
            $MR_query = "CALL MessaggiRicevuti('$emailU11')";
            $MR_result = mysqli_query($db,$MR_query);
            $varCount11 = mysqli_affected_rows($db);

            if($varCount11 <= 0){
                echo("Non hai ancora ricevuto nessun messaggio");
            }

            foreach($MR_result as $row){
                echo "<br>";
                echo("Titolo : ".$row['Titolo']);
                echo "<br>";
                echo("Testo : ".$row['Testo']);
                echo "<br>";
                echo("Data : ".$row['DataMessaggio']);
                echo "<br>";
                echo("Email amministratore : ".$row['EmailAmministratore']);
                echo("<hr>");
                }
            }
    //----------------------------------------------------------------------------------------------------------------------------------

    if($numero == 12){
        echo("<h2>RIMOZIONE PRENOTAZIONE</h2>");
        $email12 = $_SESSION['email'];
        $biblioteca12 = mysqli_real_escape_string($db, $_REQUEST['inputBiblioteca12']);
        $data12 = $_REQUEST['inputData12'];

        $EPP_query = "CALL EliminaPrenotazionePosto('$email12','$biblioteca12','$data12')";
        $EPP_result = mysqli_query($db,$EPP_query);
        $varCount12 = mysqli_affected_rows($db);

        if($varCount12 <= 0){
            echo("Mi dispiace non è presente una prenotazione a suo nome con i dati inseriti");
        } else {
            echo("La prenotazione del posto è stata rimossa");
        }

    }
    //----------------------------------------------------------------------------------------------------------------------------------

    if($numero == 13){
        echo("<h2>RIMOZIONE PRENOTAZIONE</h2>");
        $email13 = $_SESSION['email'];
        $codice13 = $_REQUEST['inputCodice13'];

        $EPL_query = "CALL EliminaPrenotazioneLibro('$email13','$codice13')";
        $EPL_result = mysqli_query($db,$EPL_query);
        $varCount13 = mysqli_affected_rows($db);

        if($varCount13 <= 1){
            echo("Non risulta una prenotazione del libro a suo nome");
        } else {
            echo("La prenotazione del libro è stata cancellata con successo");
        }

    }
    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 14){
        echo("<h2>LISTA DI EBOOK</h2>");

        $ED_query = "CALL EbookDisponibili()";
        $ED_result = mysqli_query($db,$ED_query);
        $varCount14 = mysqli_affected_rows($db);

        if($varCount14 <= 0){
            echo("Non vi sono ebook in questo momento disponibili");
        }

        foreach($ED_result as $row){
            echo "<br>";
            echo("Codice : ".$row['Codice']);
            echo "<br>";
            echo("Titolo : ".$row['Titolo']);
            echo "<br>";
            echo("Lista autori : ".$row['ListaAutori']);
            echo "<br>";
            echo("Genere : ".$row['Genere']);
            echo "<br>";
            echo("Nome edizione : ".$row['NomeEdizione']);
            echo "<br>";
            echo("Anno pubblicazione : ".$row['AnnoPubblicazione']);
            echo "<br>";
            echo("Numero accessi : ".$row['NrAccessi']);
            echo "<br>";
            echo("Dimensione : ".$row['Dimensione']);
            echo("<hr>");
            }

    }
    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 15){
        echo("<h2>CATALOGO BIBLIOTECA</h2>");
        $biblioteca15 = $_REQUEST['inputBiblioteca15'];
        $LB_query = "CALL LibriBiblioteca('$biblioteca15')";
        $LB_result = mysqli_query($db,$LB_query);
        $varCount15 = mysqli_affected_rows($db);

        if($varCount15 <= 0){
            echo("Mi dispiace non ci sono libri disponibili in questa biblioteca");
        }

        foreach($LB_result as $row){
            echo "<br>";
            echo("Codice libro : ".$row['Codice']);
            echo "<br>";
            echo("Titolo : ".$row['Titolo']);
            echo "<br>";
            echo("Lista autori : ".$row['ListaAutori']);
            echo "<br>";
            echo("Genere : ".$row['Genere']);
            echo "<br>";
            echo("Nome edizione : ".$row['NomeEdizione']);
            echo "<br>";
            echo("Anno pubblicazione : ".$row['AnnoPubblicazione']);
            echo "<br>";
            echo("Conservazione : ".$row['StatoConservazione']);
            echo "<br>";
            echo("Stato : ".$row['StatoPrestito']);
            echo "<br>";
            echo("Numero pagine : ".$row['NumeroPagine']);
            echo "<br>";
            echo("Numero scaffale : ".$row['NumeroScaffale']);
            echo("<hr>");
            }

    }
    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 16){
        echo("<h2>RISULTATO RICERCA</h2>");

        $nome16 = mysqli_real_escape_string($db, $_REQUEST['inputNome16']);
        $EDN_query = "CALL EbookDalNome('$nome16')";
        $EDN_result = mysqli_query($db,$EDN_query);
        $varCount16 = mysqli_affected_rows($db);

        if($varCount16 <= 0){
            echo("Mi dispiace non ci sono ebook con questo nome nel sistema");
        }

        foreach($EDN_result as $row){
            echo "<br>";
            echo("Codice libro : ".$row['Codice']);
            echo "<br>";
            echo("Titolo : ".$row['Titolo']);
            echo "<br>";
            echo("Lista autori : ".$row['ListaAutori']);
            echo "<br>";
            echo("Genere : ".$row['Genere']);
            echo "<br>";
            echo("Nome edizione : ".$row['NomeEdizione']);
            echo "<br>";
            echo("Anno pubblicazione : ".$row['AnnoPubblicazione']);
            echo "<br>";
            echo("Numero accessi : ".$row['NrAccessi']);
            echo "<br>";
            echo("Dimensione : ".$row['Dimensione']);
            echo("<hr>");
            }
    }
    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 17){
        echo("<h2>RISULTATO RICERCA</h2>");
        $nome17 = mysqli_real_escape_string($db, $_REQUEST['inputNome17']);
        $LDN_query = "CALL LibroDalNome('$nome17')";
        $LDN_result = mysqli_query($db,$LDN_query);
        $varCount17 = mysqli_affected_rows($db);

        if($varCount17 <= 0){
            echo("Mi dispiace non ci sono libri con questo nome nel sistema");
        }

        foreach($LDN_result as $row){
            echo "<br>";
            echo("Codice : ".$row['Codice']);
            echo "<br>";
            echo("Titolo : ".$row['Titolo']);
            echo "<br>";
            echo("Lista autori : ".$row['ListaAutori']);
            echo "<br>";
            echo("Genere : ".$row['Genere']);
            echo "<br>";
            echo("Nome edizione : ".$row['NomeEdizione']);
            echo "<br>";
            echo("Anno pubblicazione : ".$row['AnnoPubblicazione']);
            echo "<br>";
            echo("Stato conservazione : ".$row['StatoConservazione']);
            echo "<br>";
            echo("Stato prestito : ".$row['StatoPrestito']);
            echo "<br>";
            echo("Numero pagine : ".$row['NumeroPagine']);
            echo "<br>";
            echo("Numero scaffale : ".$row['NumeroScaffale']);
            echo "<br>";
            echo("Nome biblioteca : ".$row['NomeBiblioteca']);
            echo("<hr>");
            }
    }
    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 18){
        echo("<h2>CAMBIO DATA</h2>");
        $email18 = $_SESSION['email'];
        $codice18 = $_REQUEST['inputCodice18'];
        $data18 = $_REQUEST['inputData18'];

        $CCT_query = "CALL CambiaConsegnaUtilizzatore('$email18','$codice18','$data18')";
        $CCT_result = mysqli_query($db,$CCT_query);
        $varCount18 = mysqli_affected_rows($db);

        if($varCount18 <= 0){
            echo("Non è stato trovata nessuna consegna corrispondente ai dati inseriti");
        } else {
            echo("La data è stata cambiata con successo");
        }
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 19){
        echo("<h2>LISTA LIBRI</h2>");

        $LD_query = "CALL LibriDisponibili()";
        $LD_result = mysqli_query($db,$LD_query);
        $varCount19 = mysqli_affected_rows($db);

        if($varCount19 <= 0){
            echo("Non ci sono libri disponibili per la prenotazione");
        }

        foreach($LD_result as $row){
            echo "<br>";
            echo("Codice : ".$row['Codice']);
            echo "<br>";
            echo("Titolo : ".$row['Titolo']);
            echo "<br>";
            echo("Lista autori : ".$row['ListaAutori']);
            echo "<br>";
            echo("Genere : ".$row['Genere']);
            echo "<br>";
            echo("Nome edizione : ".$row['NomeEdizione']);
            echo "<br>";
            echo("Anno pubblicazione : ".$row['AnnoPubblicazione']);
            echo "<br>";
            echo("Numero pagine : ".$row['NumeroPagine']);
            echo "<br>";
            echo("Numero scaffale : ".$row['NumeroScaffale']);
            echo "<br>";
            echo("Nome biblioteca : ".$row['NomeBiblioteca']);
            echo("<hr>");
            }
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    ?>
    <br>
    <!--LINK PER TORNARE ALLA HOMEPAGE-->
    <a href = "Utilizzatore.php">Vuoi tornare alla homepage? Cliccami</a>
    </form>
  </div>
</body>
</html>
