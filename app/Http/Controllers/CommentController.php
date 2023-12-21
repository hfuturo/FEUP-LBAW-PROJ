<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Models\Vote;
use App\Models\Content;
use App\Models\Notification;
use Carbon\Carbon;

use App\Events\NewCommentNotification;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $id)
    {
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

            $news_author = FALSE;

            if ($news_item->authenticated_user) {
                if ($news_item->authenticated_user->id === $content->authenticated_user->id) {
                    $news_author = TRUE;
                }
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

        $news_item = Content::find($id);

        // envia notificação apenas se user existir
        if ($news_item->authenticated_user) {
            $notification = Notification::where('id_content', '=', $comment['id'])
                ->where('type', '=', 'content')
                ->first();
            event(new NewCommentNotification($news_item->authenticated_user->id, $news_item->id, $news_item->news_items->title, $notification->id));
        }

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

        $this->authorize('update', $comment);

        $content->content = $request->input('content');
        $content->edit_date = 'now()';
        $content->save();
        $content = $content->refresh();

        return response()->json(['success' => 'Comment edited successfully', 'edit_date' => Carbon::parse($content->edit_date)->diffForHumans()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $comment = Comment::find($id);
        $content = Content::find($id);

        $this->authorize('destroy', $comment);
        if (Auth::user()->is_admin()) {
            Vote::where('id_content', $id)->delete();
            $content->delete();
            return response()->json(['success' => 'Comment deleted successfully']);
        } else {
            if ($comment->votes()->exists()) {
                return response()->json(['error' => 'Cannot delete comment with votes']);
            } else {
                $content->delete();
                return response()->json(['success' => 'Comment deleted successfully']);
            }
        }
    }

    public function destroy_admin(Request $request)
    {
        $comment = Comment::find($request->input('request'));
        $this->authorize('destroy_admin', $comment);

        Vote::where('id_content', $request->input('request'))->delete();
        $comment->content->delete();

        $response = [
            'action' => 'delete_comment',
            'id' => $request->input("request"),
        ];
        return response()->json($response);
    }
}
