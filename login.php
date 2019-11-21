<?php
    include 'databaseManager.php';

    if ($_POST['username'] == "" || $_POST['password'] == "") {
        echo "You must fill in all fields!";
        exit;
    } else {
        $dbManager = new databaseManager();
        $dbManager->startSession();
        $loginFailed = $dbManager->attemptLogin();
    
        if ($loginFailed){
            echo "The login information does not match our records";
        } 
    }
?>