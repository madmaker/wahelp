<?php
declare(strict_types=1);

namespace Common;

use PDO;

require 'Singleton.php';

class DB extends Singleton
{
    private string $host = 'wahelp-postgresql';
    private string $db = 'wahelp';
    private string $user = 'postgres';
    private string $password = 'postgres';
    private string $dsn;
    private PDO $pdo;

    protected function __construct()
    {
        $this->dsn = "pgsql:host=$this->host;port=5432;dbname=$this->db;";
        $this->pdo = new PDO($this->dsn, $this->user, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public function getDb(): PDO
    {
        return $this->pdo;
    }

    public static function db(): PDO
    {
        $db = DB::getInstance();
        return $db->getDb();
    }
}