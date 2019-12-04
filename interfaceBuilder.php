<?php

class interfaceBuilder {

    function showBackButton() {
        echo "<div class='well well-sm'><a href='../'><big><b>&larr; Go Back</b></big></a></div>";
    }
    
    function showUploadForm() {
        echo '<form action="" method="post" enctype="multipart/form-data">
        <h2>Upload File</h2>
        <label for="fileSelect">Filename:</label>
        <input type="file" name="photo" id="fileSelect">
        <input type="submit" name="submit" value="Upload">
        <p><strong>Note:</strong> Only [insert allowed formats here] formats allowed to a max size of 5 MB.</p>
        </form>';
    }
    
}

?>