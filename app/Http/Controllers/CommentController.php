<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
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
        if (!Auth::check()) {
            return redirect()->route("login")
                ->withErrors('Not authenticated. Please log in to comment');
        }

        $request->validate([
            'content' => 'required|string|max:350',
        ]);

        $comment = DB::transaction(function () use ($request, $id) {

            $news_item = Content::find($id);

            $content = new Content();
            $content->content = $request->input('content');
            $content->id_author = Auth::user()->id;
            $content->save();
            $content = $content->refresh();

            $comment = new Comment();
            $comment->id = $content->id;
            $comment->id_news = $id;
            $comment->save();

            if ($news_item->authenticated_user->id === $content->authenticated_user->id) {
                $news_author = TRUE;
            } else {
                $news_author = FALSE;
            }

            return [
                'success' => true,
                'id' => $content->id,
                'news_author' => $news_author,
                'date' => Carbon::parse($content->date)->diffForHumans(),
                'content' => $content->content,
                'author' => $content->authenticated_user
            ];
        });

        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'content' => 'required|string|max:350',
        ]);
        $comment = Comment::find($id);
        $content = Content::find($id);

        try {
            $this->authorize('update', $comment);

            $content->content = $request->input('content');
            $content->edit_date = 'now()';
            $content->save();

            return response()->json(['success' => 'Comment edited successfully']);
        } catch (AuthorizationException $e) {
            return response()->json(['error' => 'Unauthorized action'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $comment = Comment::find($id);
        $content = Content::find($id);

        try {
            $this->authorize('delete', $comment);

            if ($comment->votes()->exists()) {
                return response()->json(['error' => 'Cannot delete comment with votes']);
            } else {
                $content->delete();
                return response()->json(['success' => 'Comment deleted successfully']);
            }
        } catch (AuthorizationException $e) {
            return response()->json(['error' => 'Unauthorized action'], 403);
        }
    }
}
