<?php

namespace App;

require_once("_connect.php");

use PDO;

class Database
{
    public static $instance = null;
    private $pdo;
    
    private function __construct()
    {
        $this->pdo = new PDO("mysql:host=".DATABASE_HOST.";dbname=".DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASS);
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    public function query(string $query, array $params = []): array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listTable(string $tableName): array
    {
        return $this->query(`SELECT * FROM ${$tableName}`);
    }
}
