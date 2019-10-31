<?php
    
class fileManager {
    
    function listFolders() {
        $directories = glob('./*' , GLOB_ONLYDIR);
        foreach ($directories as $dir)  {
            $printOut = ltrim($dir, "./");
            echo "<div class='well well-sm'><a href='$dir'><big>$printOut</big></a></div>";
        } 
    }
    
    function listFiles() {
        $files = scandir('./');
        foreach($files as $file) {
            if ($file != "." && $file != ".." && $file != "index.php" && $file != "._index.php")
                echo"<div class='well well-sm'><a href='$file'><big>$file</big></a></div>";
        }
    }
    
}
    
?>