<?php
require '../vendor/autoload.php';
use App\Models\Database;

$db = new Database();
// init database
$dbHandle = $db->getDbHandle();
//$db_found = mysqli_select_db($db_handle, $database);
echo "<pre>";
//var_dump($db_handle);
// Check if connexion is ok
if ( $dbHandle ) {
    echo "Connexion à MySQL <br>";
} else {
    echo "Connexion à MySQL impossible <br>";
    die;
}

// create table if not exists

if ( $_GET["option"] == "reset") {
    $sql = "DROP TABLE IF EXISTS `mails`";
    $result = mysqli_query($dbHandle, $sql);

    if ( $result ) {
        echo "Table mails deleted <br>";
    } else {
        echo "Table mails not deleted <br>";
    }

    $sql = "DROP TABLE IF EXISTS `users`";
    $result = mysqli_query($dbHandle, $sql);
    if ( $result ) {
        echo "Table users deleted <br>";
    } else {
        echo "Table users not deleted <br>";
    }

    $sql = "DROP TABLE IF EXISTS `reset`";
    $result = mysqli_query($dbHandle, $sql);
    if ( $result ) {
        echo "Table reset deleted <br>";
    } else {
        echo "Table reset not deleted <br>";
    }
}

$sql = "CREATE TABLE IF NOT EXISTS `mails` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `createdAt` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
)";
$result = mysqli_query($dbHandle, $sql);

// Create users table if not exists
$sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `createdAt` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
)";
$result = mysqli_query($dbHandle, $sql);

// Create reset table if not exists
$sql = "CREATE TABLE IF NOT EXISTS `reset` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `userId` INT NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `createdAt` DATETIME NOT NULL,
    `expireAt` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
)";
$result = mysqli_query($dbHandle, $sql);

// Check if table is created
if ( $result ) {
    echo "Table mails créée <br>";
    echo "Table users créée <br>";
    echo "Table reset créée <br>";
} else {
    echo "Table mails non créée <br>";
    echo "Table users non créée <br>";
    echo "Table reset non créée <br>";
    die;
}
