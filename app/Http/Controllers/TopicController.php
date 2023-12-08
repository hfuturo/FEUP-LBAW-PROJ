<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Content;

class TopicController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        $news = Content::join('news_item','content.id','=','news_item.id')
            ->where('news_item.id_topic','=',$topic->id)
            ->select('content.*');
        return view('pages.topic', ['topic' => $topic, 'news' => $news]);
    }
}
