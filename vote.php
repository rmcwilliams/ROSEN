<?php
    include 'databaseManager.php';

    $dbManager = new databaseManager();
    $dbManager->startSession();
    $dbManager->vote();
    $dbManager->endConnection();
?>