<?php
class Database
{
    public $conn;
    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbName']};charset=UTF8";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOEXCEPTION $e) {
            echo "Database Connection Failed: " . $e->getMessage();
            exit;
        }
    }

    public function query($query)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOEXCEPTION $e) {
            echo "Query Failed to Execute: " . $e->getMessage();
            exit;
        }
    }
}
