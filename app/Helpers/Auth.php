<?php

namespace App\Helpers;

// Auth exposes helper methods that interact with user session
class Auth
{
    public static function isAuthenticated(): bool {
        global $_SESSION;

        return isset($_SESSION['auth']['id']);
    }

    public static function isOwner($id): bool {
        global $_SESSION;

        return isset($_SESSION['auth']['id']) && $_SESSION['auth']['id'] == $id;
    }

    public static function setSession(array $data) {
        foreach ($data as $key=>$value) {
            $_SESSION['auth'][$key] = $value;
        }
    }

    public static function clearSession() {
        session_unset();
    }

    public static function get($key): mixed {
        if (Auth::isAuthenticated()) {
            if (isset($_SESSION['auth'][$key])) {
                return $_SESSION['auth'][$key];
            }
            return null;
        }
        return null;
    }
}