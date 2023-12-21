<?php

namespace App\Policies;

use App\Models\NewsItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class NewsItemPolicy
{
    public function destroy(User $user, NewsItem $news_item): bool
    {
        return $user->is_admin() || $user->id === $news_item->content()->first()->id_author || ($user->id_topic === $news_item->id_topic && $user->type === "moderator");
    }

    public function destroy_admin(User $user, NewsItem $news_item): bool
    {
        return  $user->is_admin() || ($user->id_topic === $news_item->id_topic && $user->type === "moderator");
    }
}
