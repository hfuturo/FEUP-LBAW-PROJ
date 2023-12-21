<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\User;
use App\Models\Content;

class TopicController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        if (!Auth::check()) {
            return redirect('/login');
        } else {
            $news = Content::join('news_item', 'content.id', '=', 'news_item.id')
                ->where('news_item.id_topic', '=', $topic->id)
                ->select('content.*', 'news_item.*');
            return view('pages.topic', ['topic' => $topic, 'news' => $news]);
        }
    }

    public function moderators()
    {
        $topics = Topic::all();
        $users = User::all()->where('type', "authenticated");

        return view('pages.moderators', ['topics' => $topics, 'users' => $users]);
    }
}
