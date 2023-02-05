<?php 

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\User;
use App\Services\UserService;
use Exception;

class UserController
{
    /**
     * @Route("/api/signup", name="handle_signup", method="POST")
     */
    public function signup()
    {
        $username = filter_input(INPUT_POST, 'username');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        if (UserService::signup($username, $email, $password))
        {
            Routing::redirectToPage('homepage');
        }
        else
        {
            Routing::redirectToCustomPage('signup', ['status'=>'rejected']);
        }
    }

    /**
     * @Route("/api/signin", name="handle_signin", method="POST")
     */
    public function signin()
    {
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        if (UserService::signin($username, $password))
        {
            Routing::redirectToPage('homepage');
        }
        else
        {
            Routing::redirectToCustomPage('signin', ['status'=>'rejected']);
        }
    }

    /**
     * @Route("/api/signout", name="handle_signout", method="GET")
     */
    public function signout()
    {
        Auth::clearSession();
        Routing::redirectToPage('homepage');
    }

    /**
     * @Route("/api/update/user/{id}/username", name="handle_username_update", method="POST")
     */
    public function update_username(int $id)
    {
        $_SESSION['form_update_username'] = '';

        $username = filter_input(INPUT_POST, 'username');

        if (Auth::isOwner($id))
        {
            try
            {
                $user = User::fetch($id);
                $user->setUsername($username);
                $user->save();

                Auth::setSession(['username' => $username]);
                $_SESSION['form_update_username'] = 'Username updated successfully';

                Routing::redirectToCustomPage('update_username', ['id'=>$id, 'status'=>'fulfilled']);
            }
            catch (Exception $e)
            {
                $_SESSION['form_update_username'] = $e->getMessage();

                Routing::redirectToCustomPage('update_username', ['id'=>$id, 'status'=>'rejected']);
            }
        }
        else
        {
            require_once APP_ROOT . '/views/Unauthorized.php';
        }
    }

    /**
     * @Route("/api/user/{id}/update/pfp", name="handle_pfp_update", method="POST")
     */
    public function update_pfp(int $id)
    {
        $_SESSION['form_update_pfp'] = '';

        if (!empty($_FILES))
        {
            if (!empty($_FILES['pfp']['name']))
            {
                $targetDir = APP_ROOT . '/public/images/uploads/pfps';
                $fileName = basename($_FILES['pfp']['name']);
                $fileType = pathinfo($fileName,PATHINFO_EXTENSION);
                $date = date('Y-m-d');
                $time = time();
                $rand = rand();
                $newFileName = $date . '-' . $time . '-' . $rand . '.' . $fileType;
                $targetFilePath = $targetDir . '/' . $newFileName;

                // Allow certain file formats
                $allowTypes = array('jpg','png','jpeg');
                if(in_array($fileType, $allowTypes))
                {
                    // Upload file to server
                    if(move_uploaded_file($_FILES["pfp"]["tmp_name"], $targetFilePath))
                    {
                        // Insert image file name into database
                        $user = User::fetch($id);
                        $user->setPfp($newFileName);
                        $user->save();
                        $_SESSION['form_update_pfp'] = 'Profile picture updated successfully';

                        Routing::redirectToCustomPage('update_pfp', ['id'=>$id, 'status'=>'fulfilled']);
                        return;
                    }
                }
                else
                {
                    $_SESSION['form_update_pfp'] = 'Only JPG, JPEG & PNG files are allowed';
                }
            }
            else
            {
                $_SESSION['form_update_pfp'] = 'Image is required';
            }
        }

        Routing::redirectToCustomPage('update_pfp', ['id'=>$id, 'status'=>'rejected']);
    }
}