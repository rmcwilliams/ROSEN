<?php
//if ($_POST['hiddenVal'] == "" || $_POST['upvote'] == "") {
 //   echo "You must fill in all fields!";
   // exit;
//}
//connect to database
include 'databaseManager.php';

$dbManager = new databaseManager();
$dbManager->startSession();
$dbManager->vote();
$dbManager->endConnection();

?>