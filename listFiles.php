<div class='well well-sm'><a href='../'><big><b>&larr; Go Back</b></big></a></div>

<?php
    $files = scandir('./');
    foreach($files as $file) {
        if ($file != "." && $file != ".." && $file != "index.php")
        echo"<div class='well well-sm'><a href='$file'><big>$file</big></a></div>";
    }
?>

<?php
// Check if the form was submitted
if (isset($_POST["submitFile"])) {
    // Check if file was uploaded without errors
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        //if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("upload/" . $filename)){
                echo $filename . " is already exists.";
            } else{
                move_uploaded_file($_FILES["photo"]["tmp_name"], "./" . $filename);
                echo "Your file was uploaded successfully.";
            } 
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
        <h2>Upload File</h2>
        <label for="fileSelect">Filename:</label>
        <input type="file" name="photo" id="fileSelect">
        <input type="submit" name="submitFile" value="Upload">
        <p><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p>
    </form>
<h3>Comments:</h3>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "rosen";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$theLocation = $_SERVER['REQUEST_URI'];
//get all comments
$sql = "SELECT * FROM comments WHERE location = '$theLocation'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<hr><p>Name: " . $row["user"]. "</p><p>Comment: " . $row["comment"]. "</p><hr>";
    }
} else {
    echo "No comments for this page. Why don't you add one below?";
}

$conn->close();
?>


<?php
if (isset($_POST["commentPost"])) {
    $name = htmlspecialchars($_POST["theName"]);
    $comment = htmlspecialchars($_POST["comment"]);
    //check to make sure fields aren't empty
    if ($name != "" && $comment != "") {
        //insert comment into database

        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "rosen";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $theLocation = $_SERVER['REQUEST_URI'];
        $sql = "INSERT INTO comments (location, user, comment)
        VALUES ('$theLocation', '$name', '$comment')";

        if ($conn->query($sql) === TRUE) {
            echo "Comment posted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        //tell user they need to fill in all fields
        echo "<script>alert('Please fill in all fields!');</script>";
    }
}
?>
<div class="row">
    <div class="col-xs-4">
        <h3>Leave a comment:</h3>
        <br>
        <form action="" method="POST">
        <div class="form-group">
            <label for="theName">Enter your name:</label>
            <input type="text" class="form-control" id="theName" name="theName">
        </div>
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
        </div>
        <button type="submit" class="btn btn-default" name="commentPost">Submit</button>
        </form>
    </div>
</div>