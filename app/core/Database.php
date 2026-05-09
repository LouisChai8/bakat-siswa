<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function connect(): PDO
    {
        if (self::$instance === null) {
            $host    = 'localhost';
            $db      = 'bakat_siswa';
            $user    = 'root';
            $pass    = '';
            $charset = 'utf8mb4';

            try {
                self::$instance = new PDO(
                    "mysql:host=$host;dbname=$db;charset=$charset",
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                http_response_code(500);
                die(json_encode(['error' => 'DB connection failed: ' . $e->getMessage()]));
            }
        }

        return self::$instance;
    }
}