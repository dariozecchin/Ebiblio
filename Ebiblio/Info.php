<?php session_start(); ?>
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
  <a class="navbar-brand" href="http://localhost/Ebiblio/"
      onclick="location.href=this.href+$_SESSION['account']+'.php';return false;">Ebiblio</a>
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
    <div class="container" id="conteinUtente">
    <form action = "Ut.php" method = "post">
    <!---------------------------------------------------------------------------------------------------------------------------------->
    <?php

    $db = mysqli_connect('localhost','root','','EBIBLIO') or die("Non è stato possibile connetersi al DB");
    $numero = $_REQUEST['numero'];
    //-----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 1){
        echo("<h2>INFORMAZIONI</h2>");
        $VB_query = "CALL VisualizzaBiblioteche()";
        $VB_result = mysqli_query($db,$VB_query);
        $varCount1 = mysqli_affected_rows($db);

        if ($varCount1<=0) {
          echo("Si è verificato un errore. Riprovare più tardi");
        }

        foreach($VB_result as $row){
            echo "<br>";
            echo("Nome : ".$row['Nome']);
            echo "<br>";
            echo("Note storiche : ".$row['NoteStoriche']);
            echo "<br>";
            echo("Sito web : ".$row['SitoWeb']); //FARE href CHE FACCIA RIFERIMENTO AL VERO SITO
            echo "<br>";
            echo("Latitudine : ".$row['Latitudine']);
            echo "<br>";
            echo("Longitudine : ".$row['Longitudine']);
            echo "<br>";
            echo("Indirizzo : ".$row['Indirizzo']);
            echo "<br>";
            echo("Email : ".$row['Email']);
            echo("<hr>");
        }
    }
if($numero == 1 ) {

?>
    <div id="DivMappa" class="map"></div>

    <script src="http://www.openlayers.org/api/OpenLayers.js"></script>
    <script>

    // Definisco la variabilie mappa come un oggetto OpenLayers.Map utilizzando il DivMappa, poi aggiungo il Layer OSM (Open Street Map)
    var Mappa = new OpenLayers.Map("DivMappa");
    Mappa.addLayer(new OpenLayers.Layer.OSM());

    // Creo l'oggetto contenente le coordinate (prima longitudine e poi latitudine)
    var LonLat = new OpenLayers.LonLat(11.356225465875625, 44.493432020547615)
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // Transformazione da WGS 1984..
            Mappa.getProjectionObject() // .. a Spherical Mercator Projection
          );

          var LonLat2 = new OpenLayers.LonLat( 11.353314508709728,44.491018348392345)
                .transform(
                  new OpenLayers.Projection("EPSG:4326"), // Transformazione da WGS 1984..
                  Mappa.getProjectionObject() // .. a Spherical Mercator Projection
                );

                var LonLat3 = new OpenLayers.LonLat( 11.342022086606354,44.49742114146915 )
                      .transform(
                        new OpenLayers.Projection("EPSG:4326"), // Transformazione da WGS 1984..
                        Mappa.getProjectionObject() // .. a Spherical Mercator Projection
                      );
                      var LonLat4 = new OpenLayers.LonLat( 11.351867369138994, 44.497890763295885 )
                            .transform(
                              new OpenLayers.Projection("EPSG:4326"), // Transformazione da WGS 1984..
                              Mappa.getProjectionObject() // .. a Spherical Mercator Projection
                            );
                            var LonLat5 = new OpenLayers.LonLat( 11.355756821108926, 44.49427175558341 )
                                  .transform(
                                    new OpenLayers.Projection("EPSG:4326"), // Transformazione da WGS 1984..
                                    Mappa.getProjectionObject() // .. a Spherical Mercator Projection
                                  );

                                  var LonLat6 = new OpenLayers.LonLat( 11.342379443420292, 44.4946382586393 )
                                        .transform(
                                          new OpenLayers.Projection("EPSG:4326"), // Transformazione da WGS 1984..
                                          Mappa.getProjectionObject() // .. a Spherical Mercator Projection
                                        );

    // Imposto lo zoom
    var zoom=16;

    // Creo una variabile contenete il layer dei marker poi collego il layer dei markers alla mappa
    var LayerMarkers = new OpenLayers.Layer.Markers( "Markers" );
    Mappa.addLayer(LayerMarkers);

    // Aggiungo al layer dei marker un marker (utilizzando l'oggetto lonLat per le coordinate)
    LayerMarkers.addMarker(new OpenLayers.Marker(LonLat2));
    LayerMarkers.addMarker(new OpenLayers.Marker(LonLat3));
    LayerMarkers.addMarker(new OpenLayers.Marker(LonLat4));
    LayerMarkers.addMarker(new OpenLayers.Marker(LonLat5));
    LayerMarkers.addMarker(new OpenLayers.Marker(LonLat6));
    // Imposto le coordinate di lonLat come centro della mappa di partenza
    Mappa.setCenter (LonLat, zoom);

    </script>
    <style>
    #DivMappa{
    width:500px;
    height:350px;

    } </style>
    <br>
    <br>


<?php
} else {
    //-----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 2){
        echo("<h2>POSTI LETTURA</h2>");
        //VisualizzaBiblioteche
        $NLB_query = "CALL NumeroPostiLetturaBiblioteca()";
        $NLB_result = mysqli_query($db,$NLB_query);
        $varCount2 = mysqli_affected_rows($db);

        if ($varCount2<=0) {
          echo("Non ci sono posti lettura registrati");
        }

        foreach($NLB_result as $row){
            echo "<br>";
            echo("Nome : ".$row['Nome']);
            echo "<br>";
            echo("Numero posti lettura : ".$row['NrPostiLettura']);
            echo("<hr>");
        }
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    if($numero == 3){
        echo("<h2>ELENCO LIBRI</h2>");
        $TIL_query = "CALL TuttiILibri()";
        $TIL_result = mysqli_query($db,$TIL_query);
        $varCount1 = mysqli_affected_rows($db);

        if ($varCount1<=0) {
          echo("Non ci sono libri registrati nel sistema");
        }

        foreach($TIL_result as $row){
            echo("Titolo libro : ".$row['Titolo']);
            echo "<br>";
            echo("Nome biblioteca : ".$row['NomeBiblioteca']);
            echo "<br>";
            echo("<hr>");

        }

    }

}
    ?>
    <br>
    <!--LINK PER TORNARE ALLA HOMEPAGE-->
    <a href = "Informazioni.php">Vuoi tornare alla homepage? Cliccami</a>
    </form>
</div>
</body>
</html>
