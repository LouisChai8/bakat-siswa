<?php
namespace App\Models;

use App\Core\Database;

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /** Find user by username */
    public function findByUsername(string $username): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    /** Find user by email */
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /** Find user by id */
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Create new user, returns new id */
    public function create(string $name, string $username, string $email, string $password): int
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare('
            INSERT INTO users (name, username, email, password)
            VALUES (?, ?, ?, ?)
        ');
        $stmt->execute([$name, $username, $email, $hash]);
        return (int) $this->db->lastInsertId();
    }
}