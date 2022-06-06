<?php
namespace App\Models;
use Exception;
use PDOException;

class Database {
    private $host = 'localhost:3306';
    private $username = 'root';
    private $password = 'password';
    private $database = 'portfolio';
    private $dbHandle;
    private $dbFound;

    public function __construct() {
        try {
            $this->dbHandle = mysqli_connect($this->host, $this->username, $this->password);
        } catch (PDOException $e) {
            echo "Connexion à MySQL impossible : " . $e->getMessage();
            die;
        }
        //$this->db_handle = mysqli_connect($this->host, $this->username, $this->password);
        try {
            $this->dbFound = mysqli_select_db($this->dbHandle, $this->database);
        } catch (Exception $e) {
            echo "Database not found";
            die;
        }
    }

    public function getDbHandle() {
        return $this->dbHandle;
    }

    public function getDbFound() {
        return $this->dbFound;
    }
}