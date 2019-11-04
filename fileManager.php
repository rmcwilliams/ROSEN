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
            if ($file != "." && $file != ".." && $file != "index.php" && $file != "._index.php") {
                $theLoc = $_SERVER['REQUEST_URI'] . $file;
                $host = "localhost";
                $username = "root";
                $password = "";
                $db = "rosen";
                // connection
                $con = new mysqli($host,$username,$password,$db);
                if ($con->connect_errno > 0) {
                    die("ERROR 01: Failed to connect to MySQL");
                }
                $sql = "SELECT * FROM votes WHERE location = '$theLoc'";
                $result = $con->query($sql);
                $theCounter = 0;
                while($row = $result->fetch_assoc()) {
                    $theCounter += $row['vote'];
                }
                $con->close();
               // $result = $conn->query($sql);
                echo"<div class='well well-sm'><a href='$file'><big>$file</big></a><a class='upvote' onclick=\"$('#clickedOne').val('$file')\">Upvote</a><a class='downvote' onclick=\"$('#clickedOne').val('$file')\">Downvote</a><p id='$file'>Score: $theCounter</p></div>";
            }
        }
    }

    function vote($upvote) {
        echo 'var upvote = ' . $upvote . ';';
        echo 'var theName = $("#clickedOne").val();';
        echo 'var hiddenVal = encodeURI(window.location.pathname) + $("#clickedOne").val();

        //process the form further using ajax call
        var http = new XMLHttpRequest();
        var root = location.protocol + "//" + location.host;
        var url = root + "/rosen/vote.php"; //can var url be inside of the if else statement below or will it not be in the same scope?

        var params = "hiddenVal=" + hiddenVal + "&upvote=" + upvote;

        http.open("POST", url, true);

        //Send the proper header information along with the request
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


        //Call a function when the state changes
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "Inserted vote 1") {
                    var currScore = parseInt($("p[id=\'" + theName + "\']").html().split(" ")[1]);
                    $("p[id=\'" + theName + "\']").html("Score: " + (currScore + 1).toString());
                } else if (this.responseText == "Inserted vote 0") {
                    var currScore = parseInt($("p[id=\'" + theName + "\']").html().split(" ")[1]);
                    $("p[id=\'" + theName + "\']").html("Score: " + (currScore - 1).toString());
                } else if (this.responseText == "Inserted vote 1 change") {
                    var currScore = parseInt($("p[id=\'" + theName + "\']").html().split(" ")[1]);
                    $("p[id=\'" + theName + "\']").html("Score: " + (currScore + 2).toString());
                } else if (this.responseText == "Inserted vote 0 change") {
                    var currScore = parseInt($("p[id=\'" + theName + "\']").html().split(" ")[1]);
                    $("p[id=\'" + theName + "\']").html("Score: " + (currScore - 2).toString());
                }
            }
        };
        http.send(params);
        return false;';
    }
    
}
?>