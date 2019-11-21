<?php
    include 'header.php';

    $managerOfFiles = new fileManager();
    $builder = new interfaceBuilder();
    
    $builder->showBackButton();
    $managerOfFiles->listFolders();

    include 'footer.php';
?>