<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function isAdmin(User $user): Response
    {
        return $user->role_id == 1 
                ? Response::allow() 
                : Response::deny('You are not authorized for this action.');
    }
}
