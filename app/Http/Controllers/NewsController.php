<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\NewsItem;
use App\Models\Tag;

class NewsController extends Controller
{
    public function list_default_feed(Request $request)
    {
        if ($request->input("search") != null) {
            return view(choose_view($request, 'pages.news'), [
                "news_list" => NewsItem::full_text_search($request->input("search")),
                "perPage" => 10
            ]);
        }

        $posts = DB::table('news_item')->select(DB::raw('content.*, news_item.title, sum(vote.vote)'))->leftJoin('vote', 'vote.id_content', '=', 'news_item.id')->join('content', 'content.id', '=', 'news_item.id')->groupBy('news_item.id')->groupBy('content.id')->orderByRaw('sum(vote.vote) DESC');
        return view(choose_view($request, 'pages.news'), ['news_list' => $posts, 'perPage' => 10]);
    }

    public function follow_list(Request $request)
    {
        $followingUsers = Auth::user()->following()->get('id_following');
        $followingTopics = Auth::user()->follow_topics()->get('id_topic');
        $followingOrganizations = Auth::user()->follow_organizations()->get('id_organization');
        $posts = DB::table('news_item')
            ->join('content', 'content.id', '=', 'news_item.id')
            ->whereIn('id_author', $followingUsers, 'or')
            ->whereIn('id_topic', $followingTopics, 'or')
            ->whereIn('id_organization', $followingOrganizations, 'or')
            ->orderBy('date', 'DESC');
        return view(choose_view($request, 'pages.news'), ['news_list' => $posts, 'perPage' => 10]);
    }

    public function recent_list(Request $request)
    {
        $posts = DB::table('news_item')->join('content', 'content.id', '=', 'news_item.id')->orderBy('date', 'DESC');
        return view(choose_view($request, 'pages.news'), ['news_list' => $posts, 'perPage' => 10]);
    }

    public function search_list(Request $request)
    {
        if ($request->input('search') == null)
            return $this->list_default_feed($request);
        return view(choose_view($request, 'pages.news'), [
            "news_list" => NewsItem::full_text_search($request->input("search")),
            "perPage" => 10
        ]);
    }

    public function advanced_search(Request $request)
    {
        $request->validate([
            "before" => "nullable|date",
            "after" => "nullable|date",
            "order" => "nullable|in:new,old,popular"
        ]);
        return view(choose_view($request, 'pages.advanced_search'), [
            "news_list" => NewsItem::multi_filter(
                $request->input("order", "new"),
                $request->input("fulltext"),
                $request->input("exact_match"),
                $request->input("title"),
                $request->input("content"),
                $request->input("author"),
                $request->input("topic"),
                Tag::parse_tags($request->input("tags")),
                $request->input("before"),
                $request->input("after"),
            ),
            "perPage" => 10
        ]);
    }
}

function choose_view(Request $request, string $default)
{
    if ($request->ajax()) return 'partials.list_feed';
    return  $default;
}
