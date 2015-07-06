<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('Location: controller.php'); 
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    

    <title>Lo tienes todo!</title>

    <!-- Bootstrap core CSS -->
    <link href="http://localhost/examenfinal/site_media/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://localhost/examenfinal/site_media/css/style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="http://getbootstrap.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://localhost/examenfinal/site_media/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="col-md-4">
          <h1>¡Lo Tenemos Todo!</h1>
        </div>        
        <div class="col-md-8" >
          <div class="text_gretting pull-right" ><p>Hola, Miguel  (<a href="http://localhost/examenfinal/site_media/html/salir.php">Salir</a>) / </p></div>
        </div>

      </div>
      <div class="deco"></div>
    </nav>
    

    <div class="container-fluid">
