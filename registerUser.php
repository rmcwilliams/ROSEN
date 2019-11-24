<?php
    include 'databaseManager.php';

    if ($_POST['username'] == "" || $_POST['password'] == "" || $_POST['passwordConf'] == "") {
        echo "You must fill in all fields!";
        exit;
    } else if ($_POST['password'] != $_POST['passwordConf']){
        echo "Password and confirm password do not match!";
        exit;
    } else {
        $dbManager = new databaseManager();
        $dbManager->startSession();
        $theResult = $dbManager->attemptRegister();

        if($theResult){
            echo "
                <h3>You were registered successfully.</h3>
                <br/>Click here to <a href='/'>Login</a>
            ";
        } else {
            echo "
                <h3>There was an error and our system was unable to register you.</h3>
            ";
        }

    }
?>