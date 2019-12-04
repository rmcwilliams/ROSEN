<?php
    include 'databaseManager.php';
    include 'fileManager.php';
    include 'interfaceBuilder.php';

    $dbManager = new databaseManager();
    $dbManager->startSession();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ROSEN</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>

    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <img src="/rosen/logo.png" height="50" width="50">&nbsp;&nbsp;&nbsp;
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/">Home</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <?php
      if (!isset($_SESSION['token'])) {
        echo '<li><a href="/register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          <li><a href="/"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
      } else {
        echo '<li><a href="/rosen/logoff.php"><big><b>' . $_SESSION['username'] . '</b></big>: Logout</a></li>';
      }
    ?>
      </ul>
  </div>
</nav>
    
        <div class="container">
