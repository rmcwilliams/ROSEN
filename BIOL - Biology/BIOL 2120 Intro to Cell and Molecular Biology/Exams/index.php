<?php
    include '../../../header.php';
?>

<div class='well well-sm'><a href='../'><big><b>&larr; Go Back</b></big></a></div>

<?php
    $files = scandir('./');
    foreach($files as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if($ext == 'pdf' || $ext == 'docx'){
            echo"<div class='well well-sm'><a href='$file'><big>$file</big></a></div>";
        }
    }
?>

<?php
    include '../../../footer.php';
?>