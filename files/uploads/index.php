<?php

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
        echo '<li class="list-group-item"><a download href="' . rawurlencode($repertoire) . '/' . rawurlencode(str_replace('/', '', $value)) . '">' . $value . '</a><br /> <a class="btn btn-sm btn-danger" href="delete.php?id='. rawurlencode($repertoire) . '/' . rawurlencode(str_replace('/', '', $value)) .'">Supprimer</a> </li>';
    }
}



?>


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