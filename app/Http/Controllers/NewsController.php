<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\NewsItem;

class NewsController extends Controller
{
    public function list_default_feed(Request $request)
    {
        if ($request->input("search") != null) {
            if ($request->input('search_type') == 'exact') {
                return view('pages.news', [
                    "news_list" => NewsItem::exact_match_search($request->input("search")),
                    "perPage" => 10,
                    'basePath' => '/api/news/search_feed'
                ]);
            }
            return view('pages.news', [
                "news_list" => NewsItem::full_text_search($request->input("search")),
                "perPage" => 10,
                'basePath' => '/api/news/search_feed'
            ]);
        }

        $posts = DB::table('news_item')->select(DB::raw('content.*, news_item.title, sum(vote.vote)'))->leftJoin('vote', 'vote.id_content', '=', 'news_item.id')->join('content', 'content.id', '=', 'news_item.id')->groupBy('news_item.id')->groupBy('content.id')->orderByRaw('sum(vote.vote) DESC');
        return view('pages.news', ['news_list' => $posts, 'perPage' => 10, 'basePath' => '/api/news/top_feed']);
    }

    public function follow_list(Request $request)
    {
        $this->authorize('follow_list', \App\News::class);
        // users que segue
        $following = Auth::user()->following()->get('id_following');
        $posts = DB::table('news_item')->join('content', 'content.id', '=', 'news_item.id')->whereIn('id_author', $following)->orderBy('date', 'DESC');
        return view('partials.list_feed', ['news_list' => $posts, 'perPage' => 10]);
    }

    public function recent_list(Request $request)
    {
        $posts = DB::table('news_item')->join('content', 'content.id', '=', 'news_item.id')->orderBy('date', 'DESC');
        return view('partials.list_feed', ['news_list' => $posts, 'perPage' => 10]);
    }

    public function top_list(Request $request)
    {
        $posts = DB::table('news_item')->select(DB::raw('content.*, news_item.title, sum(vote.vote)'))->leftJoin('vote', 'vote.id_content', '=', 'news_item.id')->join('content', 'content.id', '=', 'news_item.id')->groupBy('news_item.id')->groupBy('content.id')->orderByRaw('sum(vote.vote) DESC');
        return view('partials.list_feed', ['news_list' => $posts, 'perPage' => 10]);
    }

    public function search_list(Request $request)
    {
        if ($request->input('search') == null)
            return $this->top_list($request);
        if ($request->input('search_type') == 'exact') {
            return view('partials.list_feed', [
                "news_list" => NewsItem::exact_match_search($request->input("search")),
                "perPage" => 10
            ]);
        }
        return view('partials.list_feed', [
            "news_list" => NewsItem::full_text_search($request->input("search")),
            "perPage" => 10
        ]);
    }
}
