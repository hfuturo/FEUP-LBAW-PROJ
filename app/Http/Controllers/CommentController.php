<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Models\Content;
use Carbon\Carbon;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $id)
    {
        if(!Auth::check()){
            return redirect()->route("login")
                ->withErrors('Not authenticated. Please log in to comment');
        }
            
        $validatedData = $request->validate([
            'content' => 'required|string|max:350',
        ]);

        $comment = DB::transaction(function () use($request,$id) {

            $content = new Content();
            $content->content = $request->input('content');
            $content->id_author = Auth::user()->id;
            $content->save();
            $content = $content->refresh();

            $comment = new Comment();
            $comment->id = $content->id;
            $comment->id_news = $id;
            $comment->save();
            
            return ['success' => true, 'date' => Carbon::parse($content->date)->diffForHumans() ,'content'=>$content->content, 'author' =>$content->authenticated_user];
        
        });

        return response()->json($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $comment = Comment::find($id);
        $content = Content::find($id);
        /*$this->authorize('destroy', $comment);*/

        if($comment->votes()->exists()){
            return response()->json(['error' => 'Cannot delete comment with votes']);
        } else {
            $content->delete();
            return response()->json(['success' => 'Comment deleted successfully']);
            
        }
    }
}
