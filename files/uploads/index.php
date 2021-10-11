<?php
session_start();

function listing($repertoire)
{

    $fichier = array();

    if (is_dir($repertoire)) {

        $dir = opendir($repertoire);                              //ouvre le repertoire courant désigné par la variable
        while (false !== ($file = readdir($dir))) {                             //on lit tout et on récupere tout les fichiers dans $file

            if (!in_array($file, array('.', '..'))) {            //on eleve le parent et le courant '. et ..'

                $page = $file;                            //sort l'extension du fichier
                $page = explode('.', $page);
                $nb = count($page);
                $nom_fichier = $page[0];
                for ($i = 1; $i < $nb - 1; $i++) {
                    $nom_fichier .= '.' . $page[$i];
                }
                if (isset($page[1])) {
                    $ext_fichier = $page[$nb - 1];
                    if (!is_file($file)) {
                        $file = '/' . $file;
                    }
                } else {
                    if (!is_file($file)) {
                        $file = '/' . $file;
                    }            //on rajoute un "/" devant les dossier pour qu'ils soient triés au début
                    $ext_fichier = '';
                }

                if ($ext_fichier != 'php' and $ext_fichier != 'html') {        //utile pour exclure certains types de fichiers à ne pas lister
                    array_push($fichier, $file);
                }
            }
        }
    }

    natcasesort($fichier);                                    //la fonction natcasesort( ) est la fonction de tri standard sauf qu'elle ignore la casse

    if ( empty($fichier) ) {
        echo '<div class="alert alert-info mt-5"> Aucun fichier disponible </div>';
    }
    foreach ($fichier as $value) {
        $link = rawurlencode($repertoire) . '/' . rawurlencode(str_replace('/', '', $value));
        $message = '<li class="list-group-item">
        <h5 class="mb-3">
        
        <a class="link " target="_blank" href="' . $link . '"> '. $value .' </a>
        </h5>
        <div class="">
            <a class="btn btn-sm btn-primary" download href="' . $link . '"> <i class="fas fa-download"></i> Télécharger </a> 

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-trash"></i> Supprimer
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Supprimer ce fichier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Suppression du fichier suivant : <br><b>'. $value .'</b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a class="btn btn-danger" href="delete.php?id='. $link .'"> <i class="fas fa-trash"></i> Supprimer</a> 
                </div>
                </div>
            </div>
            </div>


        </div>
        </li>';
        echo $message;
    }
}



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
                    <div>
                        <a href="../index.php" class="btn btn-success mt-5 mb-4"><i class="fas fa-plus"></i> Ajouter un fichier </a>
                    </div>
                    <ul class="list-group">
                        <?php

                        listing('.');

                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
    


</body>

</html>