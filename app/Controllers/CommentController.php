<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;

class CommentController
{
    public function deleteOne(int $id)
    {
        if (!Auth::isAuthenticated())
        {
            Routing::redirectToPage('signin');
            return;
        }

        $comment = Comment::fetch($id);

        if ($comment)
        {
            if (Auth::isOwner($comment->getOwnerId()))
            {
                $comment->setDeleted('true');
                $comment->save();

                $postId = $comment->getPostId();
                Routing::redirectToCustomPage('post', ['id' => $postId]);
            }
            else
            {
                require_once APP_ROOT . '/views/Unauthorized.php';
            }
        }
        else
        {
            require_once APP_ROOT . '/views/404.php';
        }
    }

    public function comments(int $id)
    {
        $postId = $id;
        if (Auth::isAuthenticated()) {
            $user = User::fetch(Auth::get('id'));
        }
        require_once APP_ROOT . '/views/PostComments.php';
    }

    public function replyToComment(int $id)
    {
        if (!Auth::isAuthenticated())
        {
            Routing::redirectToPage('signin');
            return;
        }

        $errors = [];
        $comment = Comment::fetch($id);
        $user= User::fetch($comment->getOwnerId());

        if (isset($_POST['content']))
        {
            $content = filter_input(INPUT_POST, 'content');

            if ($content)
            {
                $comment = Comment::build($content, $comment->getPostId(), Auth::get('id'), $id);
                $comment->save();

                Routing::redirectToCustomPage('post', ['id'=>$comment->getPostId()]);
            }
            else
            {
                $errors['content'] = 'Message is required';
            }
        }

        require_once APP_ROOT . '/views/ReplyToComment.php';
    }

    public function replyToPost(int $id)
    {
        if (!Auth::isAuthenticated())
        {
            Routing::redirectToPage('signin');
            return;
        }

        $errors = [];

        if (isset($_POST['content']))
        {
            $content = filter_input(INPUT_POST, 'content');

            if ($content)
            {
                Comment::build($content, $id, Auth::get('id'))->save();
                Routing::redirectToCustomPage('post', ['id'=>$id]);
            }
            else
            {
                $errors['content'] = 'Message is required';
            }
        }

        require_once APP_ROOT . '/views/ReplyToPost.php';
    }

    public function editComment(int $id)
    {
        if (!Auth::isAuthenticated())
        {
            Routing::redirectToPage('signin');
            return;
        }

        $errors = [];

        $comment = Comment::fetch($id);

        if (!Auth::isOwner($comment->getOwnerId()))
        {
            require_once APP_ROOT . '/views/Unauthorized.php';
            return;
        }

        $content = $comment->getContent();

        if (isset($_POST['content']))
        {
            $content = filter_input(INPUT_POST, 'content');

            if ($content)
            {
                $comment->setContent($content);
                $comment->save();

                Routing::redirectToCustomPage('post', ['id'=>$comment->getPostId()]);
            }
            else
            {
                $errors['content'] = 'Message is required';
            }
        }
        
        require_once APP_ROOT . '/views/EditComment.php';
    }

    public function likeComment(int $id)
    {
        if (!Auth::isAuthenticated())
        {
            Routing::redirectToPage('signin');
            return;
        }

        if (Like::exists(Auth::get('id'), $id))
        {
            Like::delete(Auth::get('id'), $id);
        }
        else
        {
            Like::create(Auth::get('id'), $id);
        }

        $comment = Comment::fetch($id);
        Routing::redirectToCustomPage('post', ['id'=>$comment->getPostId()]);
    }
}