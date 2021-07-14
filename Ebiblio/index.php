<?php

session_start();

require_once "config.php";

if ( isset($_SESSION['account'])) {
 if ($_SESSION['account'] == 'Utilizzatore'){
    header("location: Utilizzatore.php");
    exit;
  }
  else   if ($_SESSION['account'] == 'Volontario'){
      header("location: Volontario.php");
      exit;
    }

    else   if ($_SESSION['account'] == 'Amministratore'){
        header("location:Amministratore.php");
        exit;
      }
}
else
{
  header("location:login.php");
}


?>
<!DOCTYPE html>
<head>

</head>
<body>

</body>
</html>
