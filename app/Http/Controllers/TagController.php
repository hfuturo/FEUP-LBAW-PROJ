<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Content;

class TagController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $news = Content::join('news_item', 'content.id', '=', 'news_item.id')
            ->join('news_tag', 'news_tag.id_news_item', '=', 'news_item.id')
            ->where('id_tag', '=', $tag->id)
            ->select('news_item.*', 'content.*');
        return view('pages.tag', ['tag' => $tag, 'news' => $news]);
    }
}
