<div class='well well-sm'><a href='../'><big><b>&larr; Go Back</b></big></a></div>

<?php
$directories = glob('./*' , GLOB_ONLYDIR);
foreach ($directories as $dir)  {
    $printOut = ltrim($dir, "./");
    echo "<div class='well well-sm'><a href='$dir'><big>$printOut</big></a></div>";
}
?>