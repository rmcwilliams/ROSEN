<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $managerOfFiles->uploadFile();
}
?>

<!--
<form action="" method="post" enctype="multipart/form-data">
        <h2>Upload File</h2>
        <label for="fileSelect">Filename:</label>
        <input type="file" name="photo" id="fileSelect">
        <input type="submit" name="submit" value="Upload">
        <p><strong>Note:</strong> Only [enter allowed file formats here] formats allowed to a max size of 5 MB.</p>
    </form>-->
