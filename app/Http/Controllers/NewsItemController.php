<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\NewsItem;
use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;
use App\Models\Content;
use App\Models\Tag;
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
            return view('pages.news')->with('success', 'Eliminated with success!');
        }
        return redirect()->route('news_page',[$id])->withErrors(['Cannot be eliminated because it has comments!']);
    }
    
    public function store(Request $request){
        if(!Auth::check()){
            return redirect()->route("login")->withErrors(['Not authenticated. Please log in']);
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
                $newsItem = new NewsItem();
                $newsItem->id_topic = $request->input('topic'); // Replace 1 with the actual topic ID
                $newsItem->title = $request->input('title');
                $newsItem->image = $imageName; // Replace with the image URL or path
                $newsItem->id = $content->id; // Set the id to link to the content id
                $newsItem->save();

                $id_news = $content->id;
        
            });
            return redirect()->route('news_page',["id"=>$id_news])
                ->with('success', 'Successfully Create!');
        }
        else{
            return redirect()->route('create_news')
                ->with('error', 'The parameters are invalid!');
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
