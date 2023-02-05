<?php

namespace App\Models;

use App\Helpers\DBConnection;
use Exception;

class Vote
{
    public static function create(int $user_id, int $post_id, int $amount): bool
    {
        $pdo = DBConnection::getDB();
        try
        {
            $stmt = $pdo->prepare("INSERT INTO vote (user_id, post_id, amount) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $post_id, $amount]);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function update(int $user_id, int $post_id, int $amount): bool
    {
        $pdo = DBConnection::getDB();
        try
        {
            $stmt = $pdo->prepare("UPDATE vote SET amount=? WHERE post_id=? AND user_id=?");
            $stmt->execute([$amount, $post_id, $user_id]);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function delete(int $post_id, int $user_id): bool
    {
        $pdo = DBConnection::getDB();
        try
        {
            $stmt = $pdo->prepare("DELETE FROM vote WHERE post_id=? AND user_id=?");
            $stmt->execute([$post_id, $user_id]);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function exists(int $user_id, int $post_id): bool
    {
        $pdo = DBConnection::getDB();
        return (bool) $pdo->query("SELECT * FROM vote WHERE user_id = $user_id AND post_id = $post_id")->fetch();
    }

    public static function getTotalVotesForPost(int $post_id): int
    {
        $pdo = DBConnection::getDB();
        $result = $pdo->query("SELECT SUM(amount) FROM vote WHERE post_id = $post_id")->fetch();

        return $result["SUM(amount)"] ?? 0;
    }

    public static function getVoteAmount(int $post_id, int $user_id): int
    {
        $pdo = DBConnection::getDB();
        $result = $pdo->query("SELECT amount FROM vote WHERE post_id = $post_id AND user_id=$user_id")->fetch();

        return $result["amount"] ?? 0;
    }
}