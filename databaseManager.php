<?php

class databaseManager {
    
    private $host = "";
    private $username = "";
    private $password = "";
    private $db = "";
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
    
    //get all votes at current location
    function queryLocation($theLoc) {
        $sql = "SELECT * FROM votes WHERE location = '$theLoc'";
        $result = $this->currentConnection->query($sql);
        return $result;
    }
    
    //see if user exists with username and password
    function checkLogin($username, $password) {
        $check = "SELECT * FROM users where username = '$username' AND password = '".md5($password)."'";
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


    function attemptRegister() {
        // removes backslashes
        $username = stripslashes($_POST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($this->currentConnection,$username); 
        
        //check if username is already taken
        $check = "SELECT * FROM users where username = '$username'";
        $res = $this->currentConnection->query($check);
        if (mysqli_num_rows($res) > 0) {
            echo "Username is already taken!";
            exit;
        }

        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($this->currentConnection,$password);
        $query = "INSERT into `users` (username, password)
        VALUES ('$username', '".md5($password)."')";
        $result = mysqli_query($this->currentConnection,$query);
        $this->endConnection();
        return $result;
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

    function showComments() {
        echo "<h3>Comments:</h3>";
        $theLocation = $_SERVER['REQUEST_URI'];
        //get all comments
        $sql = "SELECT * FROM comments WHERE location = '$theLocation'";
        $result = $this->currentConnection->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<hr><p>Username: " . $row["user"]. "</p><p>Comment: " . $row["comment"]. "</p><hr>";
            }
        } else {
            echo "No comments for this page. Why don't you add one below?";
        }
    }

    function postComment() {
        if (isset($_POST["commentPost"])) {
            $name = $_SESSION['username'];
            $comment = htmlspecialchars($_POST["comment"]);
            //check to make sure fields aren't empty
            if ($comment != "") {
                // Create connection
                $conn = $this->currentConnection;
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $theLocation = $_SESSION['requestURI'];
                $sql = "INSERT INTO comments (location, user, comment)
                VALUES ('$theLocation', '$name', '$comment')";
                if ($conn->query($sql) === TRUE) {
                    echo "Comment posted successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                //tell user they need to fill in all fields
                echo "<script>alert('Please fill in all fields!');</script>";
            }
        }
    }

}

?>
