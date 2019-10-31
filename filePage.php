<?php
    include 'header.php';
    include 'fileManager.php';
?>

<div class='well well-sm'><a href='../'><big><b>&larr; Go Back</b></big></a></div>

<?php
    $managerOfFiles = new fileManager();
    $managerOfFiles->listFiles();
?>

<?php
    include 'fileUploader.php';
    include 'footer.php';
?>