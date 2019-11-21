<?php

class databaseManager {
    
    private $host = "localhost";
    private $username = "rosen";
    private $password = "rosen";
    private $db = "rosen";
    private $currentConnection;
    
    function startConnection() {
        $this->currentConnection = new mysqli($this->host, $this->username, $this->password, $this->db);
        if ($this->currentConnection->connect_errno > 0) {
            die("ERROR 01: Failed to connect to MySQL");
        }
    }
    
    function startSession() {
        session_start();
        $this->startConnection();
    }
    
    function endConnection() {
        $this->currentConnection->close();
    }
    
    function endSession() {
        // Starts session
        session_start();
        // Unset all of the session variables
        session_unset();
        // Destroy the session
        session_destroy();
        // Sends user to the login page
        header('Location: ./index.php');
    }
    
    function queryLocation($theLoc) {
        $sql = "SELECT * FROM votes WHERE location = '$theLoc'";
        $result = $this->currentConnection->query($sql);
        return $result;
    }
    
    function checkLogin($username, $password) {
        $check = "SELECT * FROM users where username = '$username' AND password = '$password'";
        $result = $this->currentConnection->query($check);
        return $result;
    }
    
    function attemptLogin() {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $res = $this->checkLogin($username, $password);
        
        $this->endConnection();
        
        $loginFailed = mysqli_num_rows($res) == 0;
        
        if (!$loginFailed) {
            // If there is a match, set session variables
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['token'] = $username;
            // Send user to index.php
            header('Location: ./index.php');
        }
        
        return $loginFailed;
        
    }
    
    function vote() {
        
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
        $res = $this->currentConnection->query($check);

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
            $res = $this->currentConnection->query($check);

            if (mysqli_num_rows($res) > 0) {
                $theID = -1;
                while($row = $res->fetch_assoc()) {
                    $theID = $row['id'];
                }
                $sql = "UPDATE votes SET vote='$theVote' WHERE id=$theID";

                if ($this->currentConnection->query($sql) === TRUE) {
                    echo "Inserted vote $upvote change";
                } else {
                    echo "Error updating record: " . $this->currentConnection->error;
                }
            } else {
                $sql = "INSERT INTO votes (user, location, vote)
                    VALUES ('$user', '$hiddenVal', '$theVote')";

                if ($this->currentConnection->query($sql) === TRUE) {
                    echo "Inserted vote $upvote";
                } else {
                    echo "Error: " . $sql . "<br>" . $this->currentConnection->error;
                }
            }
        }
    }

}

?>