<?php

namespace Framework;

use PDO;
use PDOEXCEPTION;

class Database
{
    public $conn;
    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbName']};charset=UTF8";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOEXCEPTION $e) {
            echo "Database Connection Failed: " . $e->getMessage();
            exit;
        }
    }

    public function query($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            $stmt->execute();
            return $stmt;
        } catch (PDOEXCEPTION $e) {
            echo "Query Failed to Execute: " . $e->getMessage();
            exit;
        }
    }
}
