<?php
namespace App\Controllers;

use App\Models\CommentModel;

class CommentController
{
    private CommentModel $model;

    public function __construct()
    {
        require_once __DIR__ . '/../core/Database.php';
        require_once __DIR__ . '/../models/CommentModel.php';
        $this->model = new CommentModel();
        header('Content-Type: application/json');
    }

    /**
     * GET /comments?post_id=1
     * Returns all comments for a post
     */
    public function index(): void
    {
        $postId = (int) ($_GET['post_id'] ?? 0);

        if ($postId <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'post_id is required']);
            return;
        }

        $comments = $this->model->getByPost($postId);
        echo json_encode(['success' => true, 'data' => $comments]);
    }

    /**
     * POST /comments
     * Body JSON: { post_id, user_id, content }
     */
    public function store(): void
    {
        $body    = json_decode(file_get_contents('php://input'), true);
        $postId  = (int)    ($body['post_id']  ?? 0);
        $userId  = (int)    ($body['user_id']  ?? 0);
        $content = trim((string) ($body['content'] ?? ''));

        if ($postId <= 0 || $userId <= 0 || $content === '') {
            http_response_code(400);
            echo json_encode(['error' => 'post_id, user_id and content are required']);
            return;
        }

        if (mb_strlen($content) > 280) {
            http_response_code(422);
            echo json_encode(['error' => 'Content exceeds 280 characters']);
            return;
        }

        $comment = $this->model->create($postId, $userId, $content);
        http_response_code(201);
        echo json_encode(['success' => true, 'data' => $comment]);
    }

    /**
     * DELETE /comments/{id}
     * Body JSON: { user_id }
     */
    public function destroy(int $id): void
    {
        $body   = json_decode(file_get_contents('php://input'), true);
        $userId = (int) ($body['user_id'] ?? 0);

        $ok = $this->model->delete($id, $userId);

        if (!$ok) {
            http_response_code(403);
            echo json_encode(['error' => 'Comment not found or not authorized']);
            return;
        }

        echo json_encode(['success' => true]);
    }
}