<?php

namespace App\Policies;

use App\Models\User;
use App\Models\News_Item;

class News_ItemPolicy
{

     /**
     * Determine if a news can be created by a user.
     */
    public function create(User $user): bool
    {
        // Any user can create a new card.
        return Auth::check();
    }

}