<?php

namespace App\Policies;

use App\Models\NewsItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class NewsItemPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NewsItem $news_item): bool
    {
        return $user->id === $news_item->content()->first()->id_author;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NewsItem $newsItem): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NewsItem $newsItem): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NewsItem $newsItem): bool
    {
        //
    }

    public function destroy(User $user, NewsItem $news_item): bool
    {
        return $user->id === $news_item->content()->first()->id_author;
    }

    public function destroy_admin(User $user, NewsItem $news_item): bool
    {
        return  $user->is_admin() || ($user->id_topic === $news_item->id_topic && $user->type === "moderator");
    }
}
