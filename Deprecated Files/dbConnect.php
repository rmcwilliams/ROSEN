<?php
    session_start();
	$host = "localhost";
	$username = "rosen";
	$password = "rosen";
	$db = "rosen";
    // connection
    $con = new mysqli($host,$username,$password,$db);
    if ($con->connect_errno > 0) {
        die("ERROR 01: Failed to connect to MySQL");
    }
?>