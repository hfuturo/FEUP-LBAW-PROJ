<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\NewsItem;
use App\Models\Topic;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class NewsItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news_itens = NewsItem::all();

        return view('pages.feed', ['news_itens' => $news_itens]);
    }

    public function show(int $id): View
    {
        $news_itens = NewsItem::findOrFail($id);
        $comments = $news_itens->comments()->paginate(10);

        // Use the pages.card template to display the card.
        return view('pages.news_item', ['news_item' => $news_itens, 'comments' => $comments]);

    }

}    
