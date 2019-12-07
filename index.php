<?php
    include 'header.php';
?>

<script>
    $(document).ready(function() {
        $("#theSubmit").click(function(){
            var username = $("#username").val();
            var password = $('#password').val();
            if (username == "" || password == "") {
                $("#errorMsg").html("<b>You must enter both fields!</b>");
                return false;
            }
        }); 
    });
</script>

<?php
    if (!isset($_SESSION['token'])) {
        echo '<div align="center"><form action="login.php" method="post" style="width:30%;">
            <div id="errorMsg" style="color:red;"></div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-default" id="theSubmit">Submit</button>
        </form></div>';
    } else {
        $managerOfFiles = new fileManager();
        $managerOfFiles->listFoldersIndex();
    }
?>

<?php
    include 'footer.php';
?>