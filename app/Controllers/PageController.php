<?php 

namespace App\Controllers;

use App\Helpers\Routing;
use App\Models\Enums\GetUserBy;
use App\Models\User;
use App\Models\Vote;

class PageController
{
    /**
     * @Route("/", name="homepage", method="GET")
     */
	public function homepage()
	{
        require_once APP_ROOT . '/views/Feed.php';
    }

    /**
     * @Route("/user/{userId}/{tab}", name="profile", method="GET")
     */
    public function profile(int $userId, string $tab)
    {
        if (User::exists(GetUserBy::ID, $userId))
        {
            require_once APP_ROOT . '/views/Profile.php';
        }
        else
        {
            require_once APP_ROOT . '/views/404.php';
        }
    }

    /**
     * @Route("/signup/{status}", name="signup", method="GET")
     */
    public function signup(string $status)
    {
        require_once APP_ROOT . '/views/Signup.php';
    }

    /**
     * @Route("/signin/{status}", name="signin", method="GET")
     */
    public function signin(string $status)
    {
        require_once APP_ROOT . '/views/Signin.php';
    }

    /**
     * @Route("/user/{id}/update/username/{status}", name="update_username", method="GET")
     */
    public function update_username(int $id, string $status)
    {
        require_once APP_ROOT . '/views/UpdateUsername.php';
    }

    /**
     * @Route("/user/{id}/update/pfp/{status}", name="update_pfp", method="GET")
     */
    public function update_pfp(int $id, string $status)
    {
        require_once APP_ROOT . '/views/UpdatePfp.php';
    }

    public function dashboard() {
        require_once APP_ROOT . '/views/Dashboard.php';
    }
}