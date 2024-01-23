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
            $pdo = new PDO($dsn, $config['username'], $config['password']);
        } catch (PDOEXCEPTION $e) {
            throw new Exception("Database Connection Failed: " . $e->getMessage());
        }
    }
}
