<?php



namespace iutnc\netvod\repository;
session_start();

use PDO;
use DateTime;

class Repository
{

    static private array $config = [];
    static private ?Repository $instance = null;
    private ?PDO $pdo = null;

    static public function setConfig($file): void
    {
        self::$config = parse_ini_file($file);
    }

    static public function getInstance(): Repository
    {
        if (self::$instance === null) {
            self::$instance = new Repository();
        }
        return self::$instance;
    }

    private function __construct()
    {
        if (!empty(self::$config)) {
            $driver = self::$config['driver'];
            $host = self::$config['host'];
            $database = self::$config['database'];
            $user = self::$config['username'];
            $pass = self::$config['password'];
            $dsn = "$driver:host=$host;dbname=$database";
            try {
                $this->pdo = new PDO($dsn, $user, $pass);
            } catch (\PDOException $e) {
                echo "Erreur PDO : " . $e->getMessage() . "<br>";
            }
        } else {
            echo "Configuration vide<br>";
        }
    }

    public function getPDO(): ?PDO
    {
        return $this->pdo;
    }


}