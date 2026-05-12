<?php
namespace App\Controllers;

use App\Core\Database;

class PostController
{
    public function __construct()
    {
        require_once __DIR__ . '/../core/Database.php';
    }

    /**
     * POST /posts
     * multipart/form-data: { user_id, content, image? }
     */
    public function store(): void
    {
        header('Content-Type: application/json');

        $userId  = (int)    ($_POST['user_id']  ?? 1); // TODO: replace with session
        $content = trim((string) ($_POST['content'] ?? ''));

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

        // ── Handle image upload ──
        $imageName = null;
        if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file     = $_FILES['image'];
            $allowed  = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            $maxSize  = 10 * 1024 * 1024; // 10 MB

            if (!in_array($file['type'], $allowed)) {
                http_response_code(422);
                echo json_encode(['error' => 'Only JPG, PNG, WEBP, GIF allowed']);
                return;
            }
            if ($file['size'] > $maxSize) {
                http_response_code(422);
                echo json_encode(['error' => 'Image must be under 10MB']);
                return;
            }

            $ext       = pathinfo($file['name'], PATHINFO_EXTENSION);
            $imageName = uniqid('post_', true) . '.' . $ext;
            $uploadDir = __DIR__ . '/../../public/assets/img/';
            move_uploaded_file($file['tmp_name'], $uploadDir . $imageName);
        }

        // ── Insert into DB ──
        $db   = Database::connect();
        $stmt = $db->prepare('INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $content, $imageName]);
        $newId = (int) $db->lastInsertId();

        echo json_encode([
            'success' => true,
            'data'    => ['id' => $newId, 'content' => $content, 'image' => $imageName]
        ]);
    }

    /**
     * PUT /posts/{id}
     * Body JSON: { content }
     */
    public function update(int $id): void
    {
        header('Content-Type: application/json');

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