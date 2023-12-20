<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use App\Models\NewsItem;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        //
    }

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
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->content->id_author;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->content->id_author;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        //
    }
    public function destroy_admin(User $user, Comment $comment): bool
    {
        if($user->is_admin()){
            return true;
        }
        else if ($user->type === "moderator"){
            $news_item = NewsItem::findOrFail($comment->id_news);
            return $news_item->id_topic === $user->id_topic;
        }
        return  false;
    }

}

