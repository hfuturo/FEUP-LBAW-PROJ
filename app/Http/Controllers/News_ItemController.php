<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\News_Item;
use App\Models\Topic;
use App\Models\User;
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
        return view('pages.news', ['news_item' => $news_itens, 'comments' => $comments]);

    }

    public function api_create(Request $request)
    {
        if(!Auth::check()){
            return redirect()->route('new',["id"=>$id_news[0]->currval])
            ->with('success', 'Successfully changed!');
        }

        $request->validate([
            'image' => 'mimes:jpg,png,jped'
        ]);

        $imageName = NULL;

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = sha1($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/news_image'), $imageName);
        }

        $id_news=null;
        DB::transaction(function () use(&$id_news, $request, $imageName) {
            DB::insert('INSERT INTO content (content, id_author, id_organization) VALUES (:content, :id_author, :id_organization)',[
                "content"=>$request->input("text"),
                "id_author"=>Auth::user()->id,
                "id_organization"=> null
            ]);
            DB::insert('INSERT INTO news_item(id, id_topic, title, image) VALUES(currval(\'content_id_seq\'), :id_topic, :title, :image)',[
                "id_topic"=>1,
                "title"=>$request->input("title"),
                'image' => $imageName
            ]);

            $id_news=DB::select('SELECT currval(\'content_id_seq\')');
            /*-- cria noticia

            BEGIN TRANSACTION;
            SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
            
            INSERT INTO content (content, date, edit_date, id_author, id_organization)
            VALUES ($content, $date, $edit_date, $id_author, $id_organization);
            
            INSERT INTO news_item(id, id_topic, title)
            VALUES(currval('content_id_seq'), $id_topic, $title);
            
            -- inicio do for em php sobre tags
            INSERT INTO news_tag(id_news_item, id_tag)
            VALUES (currval('content_id_seq'), $id_tag) ;
            -- fim do for em php
            
            COMMIT;*/            
        });
        return redirect()->route('new',["id"=>$id_news[0]->currval])
        ->with('success', 'Successfully changed!');
    }

     /**
     * Show the form for creating a new resource.
     */
    function page_create(){
        $topics = Topic::all();
        return view('pages.create', ['topics' => $topics]);
    }

}    
