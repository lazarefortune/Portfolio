<?php
session_start();
if ( isset( $_GET['id'] ) ) {
    // var_dump( $_GET['id'] );
    $fileDir = $_GET['id'];
    unlink( $fileDir );
    echo "fichier supprimé";
    $error = 'info';
    $message = "Fichier supprimé avec succès";
    $_SESSION['error'] = $error;
    $_SESSION['message'] = $message;
    header("Location: index.php");
}
// die;
header("Location: index.php");

?>