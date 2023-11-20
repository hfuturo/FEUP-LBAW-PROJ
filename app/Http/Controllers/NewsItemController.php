<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\NewsItem;
use App\Models\Comment;
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

        return view('pages.news_item', ['news_item' => $news_itens, 'comments' => $comments]);
    }

    public function destroy(int $id)
    {
        $news_item = NewsItem::find($id);
        $this->authorize('destroy',$news_item);

        $comments = Comment::where('id_news',$id)->get();
        if($comments->isEmpty())
        {
            $news_item->delete();
            return view('pages.news')->with('success', 'Eliminated with sucess!');
        }
        return redirect()->route('new',[$id])->withErrors(['error', 'Cannot be eliminated because it has comments!']);
    }

}    
