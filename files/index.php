<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>PHP File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

</head>

<body>


    <form method="POST" action="upload.php" enctype="multipart/form-data">
        <!-- <div class="upload-wrapper">
            <span class="file-name">Choose a file...</span>
            <label for="file-upload">Browse<input type="file" id="file-upload" name="uploadedFile"></label>
        </div> -->

        <!-- <input type="submit" name="uploadBtn" value="Upload" /> -->


        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="my-3">
                        <?php

                        if (isset($_SESSION['message'])) {
                        ?>
                            <div class="alert alert-info">
                                <?php
                                echo  $_SESSION['message'];
                                unset($_SESSION['message']);
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Téléverser un fichier</label>
                        <input class="form-control" type="file" id="formFile" name="uploadedFile">
                    </div>
                    <div>
                        <button class="btn btn-primary" name="uploadBtn" type="submit">Envoyer à Fortune</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
</body>

</html>