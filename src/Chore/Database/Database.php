<?php

namespace App\Chore\Database;

require_once(__DIR__ ."/_connect.php");

use PDO;
use PDOException;

class Database extends PDO
{
    public static $instance = null;
    private const DBHOST = DATABASE_HOST;
    private const DBNAME = DATABASE_NAME;
    private const DBUSER = DATABASE_USERNAME;
    private const DBPASS = DATABASE_PASS;
    
    private function __construct()
    {
        // DSN de connexion
        $_dsn = 'mysql:dbname='. self::DBNAME . ';host=' . self::DBHOST;

        // On appelle le constructeur de la classe PDO
        try{
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error){
            die($error->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
}
