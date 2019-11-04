<?php
//if ($_POST['hiddenVal'] == "" || $_POST['upvote'] == "") {
 //   echo "You must fill in all fields!";
   // exit;
//}
//connect to database
require_once('./dbConnect.php');
$hiddenVal = htmlspecialchars($_POST['hiddenVal']);
$upvote = htmlspecialchars($_POST['upvote']);
$user = $_SESSION['username'];
$theVote = -1;
if ($upvote == "1") {
    $theVote = 1;
}
// make sure user hasn't already done same exact vote
$check = "SELECT * FROM votes where user = '$user' AND location = '$hiddenVal' AND vote = '$theVote'";
//run the query
$res = $con->query($check);

if (mysqli_num_rows($res) > 0) {
    echo "You already voted for this.";
} else {
    // check if voted but different
    $opposite = null;
    if ($theVote == -1) {
        $opposite = 1;
    } else if ($theVote == 1) {
        $opposite = -1;
    }
    $check = "SELECT * FROM votes where user = '$user' AND location = '$hiddenVal' AND vote = '$opposite'";
    $res = $con->query($check);

    if (mysqli_num_rows($res) > 0) {
        $theID = -1;
        while($row = $res->fetch_assoc()) {
            $theID = $row['id'];
        }
        $sql = "UPDATE votes SET vote='$theVote' WHERE id=$theID";

        if ($con->query($sql) === TRUE) {
            echo "Inserted vote $upvote change";
        } else {
            echo "Error updating record: " . $con->error;
        }
    } else {
        $sql = "INSERT INTO votes (user, location, vote)
            VALUES ('$user', '$hiddenVal', '$theVote')";

        if ($con->query($sql) === TRUE) {
            echo "Inserted vote $upvote";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
}
mysqli_close($con);
?>