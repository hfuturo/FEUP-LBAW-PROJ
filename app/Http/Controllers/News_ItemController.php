<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\News_Item;
use App\Models\Topic;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class News_itemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news_itens = News_Item::all();

        return view('pages.feed', ['news_itens' => $news_itens]);
    }

    public function show(int $id): View
    {
        $news_itens = News_Item::findOrFail($id);
        $comments = $news_itens->comments()->paginate(10);

        // Use the pages.card template to display the card.
        return view('pages.news_item', ['news_item' => $news_itens, 'comments' => $comments]);

    }

}    
