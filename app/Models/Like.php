<?php

namespace App\Models;

use App\Helpers\DBConnection;
use Exception;

class Like
{
    public static function create(int $user_id, int $comment_id): bool
    {
        $pdo = DBConnection::getDB();
        try
        {
            $stmt = $pdo->prepare("INSERT INTO comment_like (user_id, comment_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $comment_id]);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function delete(int $user_id, int $comment_id): bool
    {
        $pdo = DBConnection::getDB();
        try
        {
            $stmt = $pdo->prepare("DELETE FROM comment_like WHERE user_id = ? AND comment_id = ?");
            $stmt->execute([$user_id, $comment_id]);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function exists(int $user_id, int $comment_id): bool
    {
        $pdo = DBConnection::getDB();
        return (bool) $pdo->query("SELECT id FROM comment_like WHERE user_id = $user_id AND comment_id = $comment_id")->fetch();
    }
}