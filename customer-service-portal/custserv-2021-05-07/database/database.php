<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/autoload.php");
    
(new DotEnv($_SERVER["DOCUMENT_ROOT"] . '/.env'))->load();

class Database {
    private $conn = "";

    public function __construct() {
        $this->db_connect();
    }

    public function __destruct() {
        $this->conn = null;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    private function dbConnect() {
        try {
            $conn = new PDO(getenv('DATABASE_DNS'), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $excpetion) {
            echo "Unable to connect to database: " . $excpetion->getMessage();

            exit();
        }

        $this->conn = $conn;
    }

    public function db_connect() {
        $this->dbConnect();
    }
}