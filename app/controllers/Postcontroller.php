<?php
namespace App\Controllers;

use App\Core\Database;

class PostController
{
    public function __construct()
    {
        require_once __DIR__ . '/../core/Database.php';
        header('Content-Type: application/json');
    }

    /**
     * PUT /posts/{id}
     * Body JSON: { content }
     */
    public function update(int $id): void
    {
        $body    = json_decode(file_get_contents('php://input'), true);
        $content = trim((string) ($body['content'] ?? ''));

        if ($content === '') {
            http_response_code(400);
            echo json_encode(['error' => 'content is required']);
            return;
        }

        if (mb_strlen($content) > 280) {
            http_response_code(422);
            echo json_encode(['error' => 'Content exceeds 280 characters']);
            return;
        }

        $db   = Database::connect();
        $stmt = $db->prepare('UPDATE posts SET content = ? WHERE id = ?');
        $stmt->execute([$content, $id]);

        if ($stmt->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(['error' => 'Post not found']);
            return;
        }

        echo json_encode(['success' => true, 'data' => ['id' => $id, 'content' => $content]]);
    }
}