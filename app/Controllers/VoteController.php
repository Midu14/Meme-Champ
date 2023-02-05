<?php

namespace App\Controllers;

use App\Helpers\Routing;
use App\Models\User;
use App\Models\Vote;

class VoteController
{
    public function handleVote(int $postId, int $userId)
    {
        $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_INT);

        if ($amount)
        {
            $user = User::fetch($userId);

            if ($user)
            {
                if (Vote::exists($userId, $postId))
                {
                    if ($user->getRemainingPoggers() + Vote::getVoteAmount($postId, $userId) >= $amount)
                    {
                        Vote::update($userId, $postId, $amount);
                    }
                }
                else
                {
                    if ($user->getRemainingPoggers() >= $amount)
                    {
                        Vote::create($userId, $postId, $amount);
                    }
                }
            }
        }

        Routing::redirectToCustomPage('post', ['id' => $postId]);
    }
}