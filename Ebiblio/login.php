<?php

session_start();


if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}


require_once "config.php";


$email = $password = "";
$email_err = $password_err = "";
$account_err = $account ="";



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

    if(!isset($_POST["account"])){
        $account_err = "Inserisci il tipo del tuo account";
    } else{
        $account = trim($_POST["account"]);
    }



    if(empty($email_err) && empty($password_err) && empty($account_err)){

      if($account == "Utilizzatore"){
        // Prepare a select statement
        $sql = "SELECT email, Psw FROM utilizzatore WHERE email = ? AND StatoAccount='Attivo'";
      }
      else if($account == "Volontario"){
        // Prepare a select statement
        $sql = "SELECT email, Psw FROM volontario WHERE email = ?";
      }
      else if($account == "Amministratore"){
        // Prepare a select statement
        $sql = "SELECT email, Psw FROM amministratore WHERE email = ?";
      }
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // questo è il parametro passato nel bind
            $param_email = $email;

            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $email, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)){



                        if($password==  $hashed_password){

                            session_start();


                            $_SESSION["loggedin"] = true;
                            $_SESSION["email"] = $email;
                            $_SESSION['account'] = $_POST["account"];


                            header("location: index.php");
                        } else{
                            $password_err = "Password non valida." ;
                        }
                    }
                } else{
                    $username_err = "Nessun account trovato con quel email.";
                }
            } else{
                echo "Oops! Qualcosa non va :( riprova.";
            }

            mysqli_stmt_close($stmt);
        }
        $err_login = "Nessun account trovato oppure il tuo account è stato sospeso";
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<head>

    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navOverride">
  <a class="navbar-brand" href="login.php">Ebiblio</a>
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









    <div class="card" id="cardId">
<article class="card-body">
	<h1 class="card-title text-center mb-4 mt-1">Benvenuto su Ebiblio</h1>
	<hr>
  <?php if( !empty($err_login) || !empty($password_err)){?>
  <div class="alert alert-danger" role="alert" id="alertLogin">
      <?php echo $err_login;
      if(!empty($password_err)){
      echo " --> ".$password_err; }?>
    </div>
  <?php } ?>
	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<div class="form-group  <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
	<div class="input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
		<input name="email" class="form-control" placeholder="Email" type="email" value="<?php echo $email; ?>" required>
    <span class="help-block"><?php echo $email_err; ?></span>
	</div> <!-- input-group.// -->
	</div> <!-- form-group// -->
	<div class="form-group  <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
	<div class="input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		 </div>
	    <input class="form-control" placeholder="******" type="password" name="password" required>

	</div> <!-- input-group.// -->
	</div> <!-- form-group// -->
  <div class="form-group" id="radioId">

        Utente
        <input type="radio" name="account"
        <?php if (isset($account) && $account=="Utente") echo "checked";?>
        value="Utilizzatore" >
        Volontario
        <input type="radio" name="account"
        <?php if (isset($account) && $account=="Volontario") echo "checked";?>
        value="Volontario">
        Admin
        <input type="radio" name="account"
        <?php if (isset($account) && $account=="Admin") echo "checked";?>
        value="Amministratore">
        <?php if ( !empty($account_err)){
          ?>
        <div class="alert alert-danger" role="alert" id="alertEl">
          <?php echo $account_err; ?>
          </div>
        <?php } ?>

  </div>
	<div class="form-group">
	<button type="submit" class="btn btn-primary btn-block" value="login"> Login  </button>
	</div> <!-- form-group// -->
  <p>Non hai un account? <a href="registerUser.php">Registrati come Utente</a></p>
  <p>Oppure:  <a href="registerVol.php">Registrati come Volontario</a></p>
	</form>
</article>
</div> <!-- card.// -->

	</aside> <!-- col.// -->
</div> <!-- row.// -->

</div>
</body>
</html>
