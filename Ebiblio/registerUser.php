<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "config.php";

$email = $password = $cognome = $nome = $luogonascita = $datanascita = $recapitotelefonico = "";
$email_err = $password_err = $cognome_err = $nome_err = $luogonascita_err = $datanascita_err = $recapitotelefonico_err = "";

$campoprofessione = $campoprofessione_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["email"]))){
        $email_err = "Inserisci l'email.";
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Inserisci la password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["nome"]))){
        $nome_err = "Inserisci il nome.";
    } else{
        $nome = trim($_POST["nome"]);
    }

    if(empty(trim($_POST["cognome"]))){
        $cognome_err = "Inserisci il cognome.";
    } else{
        $cognome = trim($_POST["cognome"]);
    }

    if(empty(trim($_POST["luogodinascita"]))){
        $luogonascita_err = "Inserisci il luogo di nascita.";
    } else{
        $luogonascita = trim($_POST["luogodinascita"]);
    }

    if(empty(trim($_POST["datadinascita"]))){
        $datanascita_err = "Inserisci la data di nascita.";
    } else{
        $datanascita = trim($_POST["datadinascita"]);
    }

    if(empty(trim($_POST["telefono"]))){
        $recapitotelefonico_err = "Inserisci il numero di telefono .";
    } else{
        $recapitotelefonico = trim($_POST["telefono"]);
    }

    if(empty(trim($_POST["professione"]))){
        $campoprofessione_err = "Inserisci la tua professione .";
    } else{
        $campoprofessione = trim($_POST["professione"]);
    }



    if(empty($email_err) && empty($password_err) && empty($cognome_err) && empty($nome_err) && empty($luogonascita_err) && empty($datanascita_err)&& empty($recapitotelefonico_err)&& empty($campoprofessione_err)   ){
      $sql = "call registrazioneUtente( ?, ? , ? , ? , ? , ? , ?, ?) ";


        if($stmt = mysqli_prepare($link, $sql)){
            $param_email = $email;
            $param_pass = $password;
            $param_cognome = $cognome;
            $param_nome = $nome;
            $param_luogoN = $luogonascita;
            $param_dataN = $datanascita;
            $param_telef = $recapitotelefonico;
            $param_prof = $campoprofessione;
            mysqli_stmt_bind_param($stmt, "ssssssis", $param_email, $param_pass, $param_cognome, $param_nome, $param_luogoN, $param_dataN, $param_telef, $param_prof);



            if(mysqli_stmt_execute($stmt)){

                if($stmt->affected_rows == 1){

                    $_SESSION["loggedin"] = true;
                    $_SESSION["email"] = $email;
                    $_SESSION['account'] = 'Utilizzatore';

                    header("location: index.php");

                    if ( extension_loaded("mongodb")){

                        try {
                            $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                            $query = new MongoDB\Driver\Query([]);
                            $cursor = $manager -> executeQuery("Ebiblio.Log", $query);

                            $bulk = new MongoDB\Driver\BulkWrite;
                            $doc = [ 'log' => 'Inserito un utente: '.$email ];
                            $bulk->insert($doc);
                            $result = $manager->executeBulkWrite('Ebiblio.Log', $bulk);

                        }catch(MongoConnectionException $e){
                            var_dump($e);
                        }
                    }
                    }else{
                        echo "Problemi nell'insermento dell'account.";
                    }


                    }else{
                        echo "Oops! Qualcosa non va :(. ERROR:".htmlspecialchars($stmt->error);
                    }



            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Registrazione Utente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/styleReg.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navOverride">
  <a class="navbar-brand" href="index.php">Ebiblio</a>
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
<li>
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



    <div class="wrap" id="cartaId">
        <p class="font-weight-bold">Inserisci i tuoi dati </p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" required>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($nome_err)) ? 'has-error' : ''; ?>">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" required>
                <span class="help-block"><?php echo $nome_err; ?></span>
            </div>


            <div class="form-group <?php echo (!empty($cognome_err)) ? 'has-error' : ''; ?>">
                <label>Cognome</label>
                <input type="text" name="cognome" class="form-control" required>
                <span class="help-block"><?php echo $cognome_err; ?></span>
            </div>


                        <div class="form-group <?php echo (!empty($luogonascita_err)) ? 'has-error' : ''; ?>">
                            <label>Luogo di nascita:</label>
                            <input type="text" name="luogodinascita" class="form-control" required>
                            <span class="help-block"><?php echo $luogonascita_err; ?></span>
                        </div>



                        <div class="form-group <?php echo (!empty($datanascita_err)) ? 'has-error' : ''; ?>">
                            <label>Data di nascita:</label>
                            <input type="date" name="datadinascita" class="form-control" required>
                            <span class="help-block"><?php echo $datanascita_err; ?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($recapitotelefonico_err)) ? 'has-error' : ''; ?>">
                            <label>telefono:</label>
                            <input type="text" name="telefono" class="form-control" required>
                            <span class="help-block"><?php echo $recapitotelefonico_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($campoprofessione_err)) ? 'has-error' : ''; ?>" id ="professione">
                            <label>Professione:</label>
                            <input type="text" name="professione" class="form-control" required>
                            <span class="help-block"><?php echo $campoprofessione_err; ?></span>
                        </div>



            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrati">
            </div>
        </form>
    </div>



</body>
</html>
