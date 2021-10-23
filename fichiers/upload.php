<?php

$folderTo = 'upload/';

if ( !empty( $_FILES ) ) {
    $tempFile = $_FILES['file']['tmp_name'];
    $location = $folderTo . $_FILES['file']['name'];
    move_uploaded_file( $tempFile, $location );
}

?>