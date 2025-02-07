<?php
session_start();
require_once __DIR__ . '/../models/Comment.php';

class CommentController {
    public static function addComment() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../login.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_post'])) {
            $userId = $_SESSION['user_id'];
            $postId = intval($_POST['post_id']);
            $content = trim($_POST['comment_content']);

            if (!empty($content)) {
                Comment::addComment($userId, $postId, $content);
            }

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}

