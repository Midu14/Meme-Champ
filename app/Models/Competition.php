<?php

namespace App\Models;

use App\Helpers\DBConnection;

class Competition
{
    public static function fetchCurrent() {
        return DBConnection::getDB()->query("SELECT * FROM competition ORDER BY created_at DESC")->fetch();
    }

    public static function fetchPrevious() {
        $stmt = DBConnection::getDB()->query("SELECT * FROM competition ORDER BY created_at DESC");
        $stmt->fetch();
        return $stmt->fetch();
    }

    public static function createNew(): bool
    {
        return DBConnection::getDB()->prepare("INSERT INTO competition (is_active) VALUES (true)")->execute();
    }
}