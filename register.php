<?php
    include 'header.php';
?>

<script>
    $(document).ready(function() {
        $("#theSubmit").click(function(){
            var username = $("#username").val();
            var password = $('#password').val();
            var confPass = $('#passwordConf').val();
            if (username == "" || password == "" || confPass == "") {
                $("#errorMsg").html("<b>You must enter all fields!</b>");
                return false;
            }
            if (password != confPass) {
                $("#errorMsg").html("<b>Password and confirm password do not match!</b>");
                return false;
            }
        }); 
    });
</script>

<?php
    echo '<div align="center"><form action="registerUser.php" method="post" style="width:30%;">
        <div id="errorMsg" style="color:red;"></div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="passwordConf">Confirm Password:</label>
            <input type="password" class="form-control" id="passwordConf" name="passwordConf">
        </div>
        <button type="submit" class="btn btn-default" id="theSubmit">Submit</button>
    </form></div>';
?>

<?php
    include 'footer.php';
?>