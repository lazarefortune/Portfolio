<?php
session_start();
require '../vendor/autoload.php';

$view = isset($_GET['view']) ? $_GET['view'] : 'home';

ob_start();

if ( file_exists( 'views/' . $view . '.php' ) ) {
    include 'views/' . $view . '.php';
} else {
    include 'views/404.php';
}

$content = ob_get_clean();

require 'template/default.php';


