<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\User;
use App\Models\Content;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::orderBy('name', 'ASC')->get();
        return view('pages.topics', ['topics' => $topics]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        $news = Content::join('news_item', 'content.id', '=', 'news_item.id')
            ->where('news_item.id_topic', '=', $topic->id)
            ->select('content.*', 'news_item.*');
        return view('pages.topic', ['topic' => $topic, 'news' => $news]);
    }

    public function moderators()
    {
        $topics = Topic::all();
        $users = User::all()->where('type', "authenticated");

        return view('pages.moderators', ['topics' => $topics, 'users' => $users]);
    }

    public function filter(Request $request)
    {
        $topics = Topic::where('name', 'ilike', "%{$request->input('search')}%")
            ->join('news_item', 'news_item.id_topic', '=', 'topic.id', 'left')
            ->groupBy('topic.id')
            ->orderBy('topic.name', 'ASC')
            ->select(['topic.*', DB::raw('count(news_item.id)')])
            ->get();

        $followers = Topic::where('name', 'ilike', "%{$request->input('search')}%")
            ->join('follow_topic', 'follow_topic.id_topic', '=', 'topic.id', 'left')
            ->groupBy('topic.id')
            ->orderBy('topic.name', 'ASC')
            ->select(['topic.*', DB::raw('count(follow_topic.id_following)')])
            ->get();

        return response()->json(['topics' => $topics, 'followers' => $followers]);
    }
}
