<?php
session_start();
session_destroy();
unset( $_SESSION['username'] );
// remove cookie email if exists
if ( isset( $_COOKIE['email'] ) ) {
    unset( $_COOKIE['email'] );
    setcookie( "email", "", time() - 3600 );
}
header( "location: login.php" );