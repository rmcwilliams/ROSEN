<?php
    include 'header.php';

    $managerOfFiles = new fileManager();
    $builder = new interfaceBuilder();

    $builder->showBackButton();
    $managerOfFiles->listFiles();
    $builder->showUploadForm();

    include 'fileUploader.php';

    $dbManager->showComments();
    $managerOfFiles->commentForm();


    include 'footer.php';
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