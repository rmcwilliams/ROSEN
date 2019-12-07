<?php

class fileManager {
    
    function listFoldersIndex() {
        $directories = glob('./*' , GLOB_ONLYDIR);
        foreach ($directories as $dir) {
            $printOut = ltrim($dir, "./");
            echo "<div class='well well-sm'><a href='$dir'><big>$printOut</big></a></div>";
        }
    }
    
    function listFolders() {
        $directories = glob('./*' , GLOB_ONLYDIR);
        foreach ($directories as $dir) {
            $printOut = ltrim($dir, "./");
            echo "<div class='well well-sm'><a href='$dir'><big>$printOut</big></a></div>";
        } 
    }
    
    function listFiles() {
        $files = scandir('./');
        foreach($files as $file) {
            if ($file != "." && $file != ".." && $file != "index.php" && $file != "._index.php") {
                $theLoc = $_SERVER['REQUEST_URI'] . $file;
                
                $dbManager = new databaseManager();
                $dbManager->startConnection();
                $result = $dbManager->queryLocation($theLoc);
                $dbManager->endConnection();

                $theCounter = 0;
                while($row = $result->fetch_assoc()) {
                    $theCounter += $row['vote'];
                }
                
               // $result = $conn->query($sql);
                echo"<div class='well well-sm'><a href='$file'><big>$file</big></a><a class='upvote' onclick=\"$('#clickedOne').val('$file')\">Upvote</a><a class='downvote' onclick=\"$('#clickedOne').val('$file')\">Downvote</a><p id='$file'>Score: $theCounter</p></div>";
            }
        }
    }
    
    function uploadFile() {
        //$uri = $_SERVER['REQUEST_URI'];
        // Check if file was uploaded without errors
        if (isset($_FILES["photo"])) {
            if ($_FILES["photo"]["error"] == 0) {
                $allowed = array("pdf" => "application/pdf", "doc" => "application/msword", "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "xls" => "application/vnd.ms-excel", "ppt" => "application/vnd.ms-powerpoint", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "png" => "image/png", "jpeg" => "image/jpeg", "zip" => "application/zip");
                $filename = $_FILES["photo"]["name"];
                $filetype = $_FILES["photo"]["type"];
                $filesize = $_FILES["photo"]["size"];
        
                // Verify file extension
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
                // Verify file size - 5MB maximum
                $maxsize = 5 * 1024 * 1024;
                if ($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
        
                // Verify MYME type of the file
                if (in_array($filetype, $allowed)) {
                    // Check whether file exists before uploading it
                    if (file_exists("upload/" . $filename)) {
                        echo $filename . " is already exists.";
                    } else {
                        move_uploaded_file($_FILES["photo"]["tmp_name"], "./" . $filename);
                        echo "<script>window.location.href = window.location.href;</script>";
                    } 
                } else {
                    echo "Error: File type not allowed."; 
                }
            } else {
                echo "Error: " . $_FILES["photo"]["error"];
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
        var url = root + "/vote.php"; //can var url be inside of the if else statement below or will it not be in the same scope?

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

    function commentForm() {
        $_SESSION['requestURI'] = $_SERVER['REQUEST_URI'];
        echo '
            <div class="row">
                <div class="col-xs-4">
                    <h3>Leave a comment:</h3>
                    <br>
                    <form action="/postComment.php" method="POST">
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
                    </div> 
                    <button type="submit" class="btn btn-default" name="commentPost">Submit</button>
                    </form>
                </div>
            </div>
        ';
    }
    
}

?>