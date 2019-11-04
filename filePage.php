<?php
    include 'header.php';
    include 'fileManager.php';
    $managerOfFiles = new fileManager();
?>
<script>
    $(document).ready(function(){
        $(".upvote").click(function(){
            <?php
                $managerOfFiles->vote(1);
            ?>
        });
        $(".downvote").click(function(){
            <?php
                $managerOfFiles->vote(0);
            ?>
        });
    });
</script>
<input type="hidden" id="clickedOne" name="clickedOne" value="">
<div class='well well-sm'><a href='../'><big><b>&larr; Go Back</b></big></a></div>

<?php
    $managerOfFiles->listFiles();
?>

<?php
    include 'fileUploader.php';
    include 'footer.php';
?>