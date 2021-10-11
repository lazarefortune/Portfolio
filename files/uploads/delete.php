<?php
session_start();
if ( isset( $_GET['id'] ) ) {
    $fileDir = $_GET['id'];
   
    if( !file_exists($fileDir) ) {
        $_SESSION['error'] = 'warning';
        $_SESSION['message'] = 'Ce fichier n\'existe pas';
        header("Location: index.php");
    }else{
        unlink( $fileDir );
        $error = 'info';
        $message = "Fichier supprimé avec succès";
        $_SESSION['error'] = $error;
        $_SESSION['message'] = $message;
        header("Location: index.php");
    }
}else{

    $_SESSION['error'] = 'warning';
    $_SESSION['message'] = 'Veuillez sélectionner un fichier';
    header("Location: index.php");
}

?>