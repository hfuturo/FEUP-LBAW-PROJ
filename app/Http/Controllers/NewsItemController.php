<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\NewsItem;
use App\Models\Comment;
use App\Models\Vote;
use App\Models\Topic;
use App\Models\User;
use App\Models\Content;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\NewsTag;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


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
        $this->authorize('destroy', $news_item);


        $comments = Comment::where('id_news', $id)->get();
        if ($comments->isEmpty()) {
            if ($news_item->image !== NULL) {
                unlink(public_path("post/" . $news_item->image));
            }
            $news_item->delete();
            return redirect()->route('news')->with('success', 'Eliminated with success!');
        }
        return redirect()->route('news_page', [$id])->withErrors(['Cannot be eliminated because it has comments!']);
    }

    public function destroy_admin(Request $request)
    {
        $this->authorize('destroy_admin', \App\NewsItem::class);

        Comment::where('id_news', $request->input('request'))->delete();
        Vote::where('id_content', $request->input('request'))->delete();
        NewsItem::where('id', $request->input('request'))->delete();

        $response = [
            'action' => 'delete_news_item',
            'id' => $request->input("request"),
        ];
        return response()->json($response);
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('create', \App\NewsItem::class);

        $request->validate([
            'title' => 'required|unique:news_item,title|max:255|string',
            'text' => 'required|string',
            'topic' => 'required|int',
            'tags' => 'nullable|string',
            'image' => 'mimes:jpg,png,jpeg',
        ]);

        $imageName = NULL;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $imageName = $requestImage->hashName();
            $requestImage->move(public_path('post/'), $imageName);
        }

        $id_news = NULL;
        try {
            DB::transaction(function () use (&$id_news, $request, $imageName) {

                $content = new Content();
                $content->content = $request->input('text');
                $content->id_author = Auth::user()->id;
                $content->id_organization = $request->input('organization');
                $content->save();
                // Create a new news item associated with the content
                $newsItem = new NewsItem();
                $newsItem->id_topic = $request->input('topic'); // Replace 1 with the actual topic ID
                $newsItem->title = $request->input('title');
                $newsItem->image = $imageName; // Replace with the image URL or path
                $newsItem->id = $content->id; // Set the id to link to the content id
                $newsItem->save();

                $tags = Tag::parse_tags($request->input('tags'));
                foreach ($tags as $tag) {
                    $takeTag = Tag::firstOrCreate(['name' => $tag], ['name' => $tag]);
                    NewsTag::create([
                        'id_tag' => $takeTag->id,
                        'id_news_item' => $newsItem->id
                    ]);
                }

                $id_news = $content->id;
            });
            return redirect()->route('news_page', ["id" => $id_news])
                ->with('success', 'Successfully Create!');
        } catch (Exception $e) {
            return redirect()->route('create_news')
                ->withErrors('The parameters are invalid!');
        }
    }


    /** 
     * Show the form for creating a news item.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route("login")
                ->withErrors('Not authenticated. Please log in');
        }
        $topics = Topic::all();
        $tags = Tag::all();
        $organizations = Auth::user()->organizations()->get();
        return view('pages.create', ['topics' => $topics, 'tags' => $tags, 'organizations' => $organizations]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        if (!Auth::check()) {
            return redirect()->route("login")
                ->withErrors('Not authenticated. Please log in');
        }
        $news_item = NewsItem::find($id);
        $this->authorize('update', $news_item);
        $topics = Topic::all();
        $tags = Tag::all();
        $organizations = Auth::user()->organizations()->get();
        return view('pages.edit', ['topics' => $topics, 'tags' => $tags, 'news_item' => $news_item, 'organizations' => $organizations]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $news_item = NewsItem::find($id);
        $this->authorize('update', $news_item);
        $request->validate([
            'title' => 'required|max:255|string',
            'text' => 'required|string',
            'topic' => 'required',
            'tags' => 'nullable|string',
            'image' => 'mimes:jpg,png,jped',

        ]);
        $imageName = NULL;


        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $imageName = $requestImage->hashName();
            $requestImage->move(public_path('post/'), $imageName);
        }

        $news_item->hasMany(NewsTag::class, 'id_news_item')->delete();

        $tags = Tag::parse_tags($request->input("tags"));
        foreach ($tags as $tag) {
            $takeTag = Tag::firstOrCreate(['name' => $tag], ['name' => $tag]);
            NewsTag::create([
                'id_tag' => $takeTag->id,
                'id_news_item' => $news_item->id
            ]);
        }

        $content = Content::find($id);
        $content->content = $request->input('text');
        $content->id_organization = $request->input('organization');
        $content->edit_date = 'now()';
        $content->save();

        if ($news_item->image !== NULL) {
            unlink(public_path("post/" . $news_item->image));
        }

        $news_item->id_topic = $request->input('topic');
        $news_item->title = $request->input('title');
        $news_item->image = $imageName;
        $news_item->save();

        return redirect()->route('news_page', ["id" => $id])
            ->with('success', 'Successfully edited!');
    }
}
