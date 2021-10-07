<?php

if ( isset( $_GET['id'] ) ) {
    // var_dump( $_GET['id'] );
    $fileDir = $_GET['id'];
    unlink( $fileDir );
}
// die;
echo "fichier supprimé";

header( "Location: index.php" );
?>