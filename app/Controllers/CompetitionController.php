<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Competition;
use App\Models\Post;
use App\Models\User;

class CompetitionController
{
    public function endCompetition() {
        if (Auth::isAuthenticated()) {
            $user = User::fetch(Auth::get('id'));
            if ($user->isIsAdmin()) {

                $posts = Post::fetchPostsWithTotalVotes();
                usort($posts, function ($item1, $item2) {
                    return $item2['totalVotes'] <=> $item1['totalVotes'];
                });

                echo "<pre>";
                print_r($posts);
                echo "</pre>";

                Competition::createNew();

                if (isset($posts[0])) {
                    $user = User::fetch($posts[0]['user_id']);

                    $user->setMaxPoggers($user->getMaxPoggers()+30);
                    $user->save();

                    print_r($user);
                }

                if (isset($posts[1])) {
                    $user = User::fetch($posts[1]['user_id']);
                    $user->setMaxPoggers($user->getMaxPoggers()+20);
                    $user->save();
                }

                if (isset($posts[2])) {
                    $user = User::fetch($posts[2]['user_id']);
                    $user->setMaxPoggers($user->getMaxPoggers()+10);
                    $user->save();
                }

                // YOOOLOOOO letss goooo
                Routing::redirectToPage('dashboard');

            } else {
                require_once APP_ROOT . '/views/Unauthorized.php';
            }
        } else {
            require_once APP_ROOT . '/views/Unauthorized.php';
        }
    }
}