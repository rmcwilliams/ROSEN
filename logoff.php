<?php
   /* Logs the user off and sends them back to the login page */
   // starts session
   session_start();
   // unset all of the session variables
   session_unset();
   // destroy the session
   session_destroy();
   //sends user to the login page
   header('Location: ./index.php');
?>