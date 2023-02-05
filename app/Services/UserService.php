<?php

namespace App\Services;

use App\Framework\Exceptions\InvalidFieldValueException;
use App\Helpers\Auth;
use App\Models\Enums\GetUserBy;
use App\Models\User;

class UserService
{
    public static function signup(string $username, string $email, string $password): bool
    {
        // Create default form signup state
        $_SESSION['form_signup'] = [
            'values' => [
                'username' => $username,
                'email' => $email,
                'password' => $password
            ],
            'errors' => []
        ];

        $user = new User();

        // VALIDATE USERNAME
        try {
            $user->setUsername($username);
        } catch (InvalidFieldValueException $e) {
            $_SESSION["form_signup"]['errors']['username'] = $e->getMessage();
        }

        // VALIDATE EMAIL
        try {
            $user->setEmail($email);
        } catch (InvalidFieldValueException $e) {
            $_SESSION["form_signup"]['errors']['email'] = $e->getMessage();
        }

        // VALIDATE PASSWORD
        try {
            $user->setPassword($password);
        } catch (InvalidFieldValueException $e) {
            $_SESSION["form_signup"]['errors']['password'] = $e->getMessage();
        }

        if (empty($_SESSION['form_signup']['errors']))
        {
            $user->save();
            $user->load(GetUserBy::USERNAME, $username);
            Auth::setSession(['username'=>$user->getUsername(), 'id'=>$user->getId()]);

            return true;
        }
        else
        {
            return false;
        }
    }

    public static function signin(string $username, string $password): bool
    {
        $_SESSION['form_signin'] = [
            'errors' => []
        ];

        if (!$username)
        {
            $_SESSION['form_signin']['errors']['username'] = "Username is required";
        }
        if (!$password)
        {
            $_SESSION['form_signin']['errors']['password'] = "Password is required";
        }

        if (empty($_SESSION['form_signin']['errors']))
        {
            $user = new User();
            // if user with provided username was found
            if ($user->load(GetUserBy::USERNAME, $username))
            {
                // verify if the passwords match
                if ($user->getPassword() == $password)
                {
                    // add user info to the current session
                    Auth::setSession(['username' => $user->getUsername(), 'id' => $user->getId()]);

                    return true;
                }
                else
                {
                    $_SESSION['form_signin']['errors']['global'] = "Invalid credentials";
                }
            }
            else
            {
                $_SESSION['form_signin']['errors']['global'] = "Invalid credentials";
            }
        }

        return false;
    }
}