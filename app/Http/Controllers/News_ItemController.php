<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\News_Item;
use App\Models\Topic;
use App\Models\User;
use App\Models\Content;
use App\Models\Tag;
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

    public function store(Request $request){
        if(!Auth::check()){
            return redirect()->route("login")
            ->withErrors('fail', 'Not authenticated. Please log in');
        }

        $validator = $request->validate([
            'title' => 'required|unique:news_item,title|max:255|string',
            'text' => 'required|string',
            'topic' => 'required',
            'image' => 'mimes:jpg,png,jped',

        ]);

        if($validator){

            $imageName = NULL;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $requestImage = $request->image;
                $extension = $requestImage->extension();
                $imageName = sha1($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                $requestImage->move(public_path('img/news_image'), $imageName);
            }

            $id_news = NULL;
        
            DB::transaction(function () use(&$id_news, $request, $imageName) {

                $content = new Content();
                $content->content = $request->input('text');
                $content->id_author = Auth::user()->id;
                $content->id_organization = NULL;
                $content->save();

                // Create a new news item associated with the content
                $newsItem = new News_Item();
                $newsItem->id_topic = $request->input('topic'); // Replace 1 with the actual topic ID
                $newsItem->title = $request->input('title');
                $newsItem->image = $imageName; // Replace with the image URL or path
                $newsItem->id = $content->id; // Set the id to link to the content id
                $newsItem->save();

                $id_news = $content->id;
        
            });
            return redirect()->route('new',["id"=>$id_news])
                ->with('success', 'Successfully Create!');
        }
        else{
            return redirect()->route('create_news')
                ->with('fail', 'The parameters are invalid!');
        }

    }

    /** 
    * Show the form for creating a new resource.
    */
    public function create(){
        $topics = Topic::all();
        $tags = Tag::all();
        return view('pages.create', ['topics' => $topics, 'tags' =>$tags]);
    }

}    
