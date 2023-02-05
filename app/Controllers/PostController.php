<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Enums\GetUserBy;
use App\Models\Post;
use App\Models\User;

class PostController
{
    public function show(int $id) {
         $post = new Post();
         if ($post->load($id))
         {
             $user = new User();
             $user->load(GetUserBy::ID, $post->getUserId());
             require_once APP_ROOT . '/views/PostComments.php';
         }
         else
         {
             require_once APP_ROOT . '/views/404.php';
         }
    }

    public function createPost() {
        if (Auth::isAuthenticated()) {
            if (isset($_POST) && !empty($_FILES)) {
                $title = filter_input(INPUT_POST, 'title');

                if (!empty($_FILES['image']['name']) && $title)
                {
                    $targetDir = APP_ROOT . '/public/images/uploads/memes';
                    $fileName = basename($_FILES['image']['name']);
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
                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath))
                        {
                            Post::build(Auth::get('id'), $title, $newFileName)->save();
                            Routing::redirectToPage('homepage');
                        }
                    }
                }
            }

            require_once APP_ROOT . '/views/CreatePost.php';
        } else {
            Routing::redirectToPage('homepage');
        }
    }
}