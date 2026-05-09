<?php
namespace App\Models;

use App\Core\Database;

class CommentModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /** Get all comments for a post, newest last */
    public function getByPost(int $postId): array
    {
        $stmt = $this->db->prepare('
            SELECT c.id, c.content, c.created_at,
                   u.id AS user_id, u.name, u.username, u.profile_pic
            FROM   comments c
            JOIN   users    u ON u.id = c.user_id
            WHERE  c.post_id = ?
            ORDER  BY c.created_at ASC
        ');
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    /** Insert a new comment, return full row */
    public function create(int $postId, int $userId, string $content): array|false
    {
        $stmt = $this->db->prepare('
            INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)
        ');
        $stmt->execute([$postId, $userId, $content]);
        $id = (int) $this->db->lastInsertId();

        $stmt2 = $this->db->prepare('
            SELECT c.id, c.content, c.created_at,
                   u.id AS user_id, u.name, u.username, u.profile_pic
            FROM   comments c
            JOIN   users    u ON u.id = c.user_id
            WHERE  c.id = ?
        ');
        $stmt2->execute([$id]);
        return $stmt2->fetch();
    }

    /** Delete a comment — returns true if a row was deleted */
    public function delete(int $commentId, int $userId): bool
    {
        $stmt = $this->db->prepare('
            DELETE FROM comments WHERE id = ? AND user_id = ?
        ');
        $stmt->execute([$commentId, $userId]);
        return $stmt->rowCount() > 0;
    }
}