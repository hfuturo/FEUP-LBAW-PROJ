<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use App\Models\NewsItem;
use App\Models\Comment;

class ReportPolicy
{
    public function show_users(User $user): bool
    {
        return $user->is_admin();
    }

    public function show_news(User $user): bool
    {
        return $user->is_admin() || $user->type === "moderator";
    }

    public function show_comments(User $user): bool
    {
        return $user->is_admin() || $user->type === "moderator";
    }

    public function destroy(User $user, Report $report): bool
    {
        if($user->is_admin()){
            return true;
        }
        $news_item = NewsItem::find($report->id_content);
        if($news_item){
            return  $user->id_topic === $news_item->id_topic;
        }
        $comment = Comment::find($report->id_content);
        if($comment){
            $news_item = NewsItem::find($comment->id_news);
            if($news_item){
                return  $user->id_topic === $news_item->id_topic;
            }
        }
        return false;
    }
}
