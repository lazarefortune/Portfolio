<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fortune Documents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

</head>

<body>


    <div class="container">

        <div class="row">
            <!-- <div class="upload-wrapper">
                <span class="file-name">Choose a file...</span>
                <label for="file-upload">Browse<input type="file" id="file-upload" name="uploadedFile"></label>
            </div> -->
            
            <!-- <input type="submit" name="uploadBtn" value="Upload" /> -->
            
            
            <div class="col-12 col-sm-12 col-md-6 mx-auto">
                    <form method="POST" action="upload.php" enctype="multipart/form-data">
                    <div>
                        <a href="uploads/index.php" class="btn btn-success mt-5"> <i class="fas fa-file-download"></i> Liste des fichiers </a>
                    </div>
                    <div class="my-3">
                        <?php

                        if (isset($_SESSION['message'])) {
                        ?>
                            <div class="alert alert-<?= $_SESSION['error'] ?>">
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
                        <label for="formFile" class="form-label h4">Téléverser un fichier</label>
                        <input class="form-control" type="file" id="formFile" name="uploadedFile" multiple>
                    </div>
                    <div>
                        <button class="btn btn-primary" name="uploadBtn" type="submit"> <i class="fas fa-paper-plane"></i> Envoyer à Fortune</button>
                    </div>

                </form>
                </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
</body>

</html>