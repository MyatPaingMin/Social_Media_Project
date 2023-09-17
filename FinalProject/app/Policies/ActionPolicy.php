<?php

namespace App\Policies;

use App\Models\Action;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActionPolicy
{
    public function create_action(User $user):bool
    {
        logger('create');
        return $user->id === $userID;
    }

    public function update_action(User $user, Action $action):bool
    {
        logger($user->id);
        return $user->id === $action->user_id;
    }

    public function view_action(User $user, $userID):bool
    {
        return $user->id === $userID;
    }
}
