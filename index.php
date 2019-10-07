<?php
    include 'header.php';
?>

<?php
$directories = glob('./*' , GLOB_ONLYDIR);
foreach ($directories as $dir)  {
    $printOut = ltrim($dir, "./");
    echo "<div class='well well-sm'><a href='$dir'><big>$printOut</big></a></div>";
}
?>

<?php
    include 'footer.php';
?>