<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function connect(): PDO
    {
        // Set PHP timezone — change to match your server location
        date_default_timezone_set('Asia/Jakarta');

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
                // Sync MySQL timezone with PHP timezone
                $offset = (new \DateTime())->format('P'); // e.g. +07:00
                self::$instance->exec("SET time_zone = '$offset'");
            } catch (PDOException $e) {
                http_response_code(500);
                die(json_encode(['error' => 'DB connection failed: ' . $e->getMessage()]));
            }
        }

        return self::$instance;
    }
}