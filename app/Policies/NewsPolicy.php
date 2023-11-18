<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class NewsPolicy
{
    public function __construct()
    {
        //
    }

    public function follow_list(): bool
    {
        return Auth::check();
    }
}

?>