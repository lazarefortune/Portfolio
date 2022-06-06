<?php
namespace App\Models;
use Exception;
use PDOException;

class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $dbHandle;
    private $dbFound;

    public function __construct() {
        try {
            (new DotEnv(__DIR__ . '/../../.env'))->load();
        }catch (
            Exception $e
        ) {
            echo "Error: " . $e->getMessage();
        }

        $this->host = getenv('DB_HOST');
        if (!empty(getenv('DB_PORT'))) {
            $this->host .= ':' . getenv('DB_PORT');
        }
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
        $this->database = getenv('DB_NAME');

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