<?php
if ($_POST['username'] == "" || $_POST['password'] == "") {
    echo "You must fill in all fields!";
    exit;
}
//connect to database
require_once('./dbConnect.php');
$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
// check if login info matches user in db
$check = "SELECT * FROM users where username = '$username' AND password = '$password'";
//run the query
$res = $con->query($check);
// if there is no match, echo a message
if (mysqli_num_rows($res) == 0) {
    echo "The login information does not match our records";
} else {
    // if there is a match, set session variables
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['token'] = $username;
    // send user to index.php
    header('Location: ./index.php');
    exit;
}
mysqli_close($con);
?>