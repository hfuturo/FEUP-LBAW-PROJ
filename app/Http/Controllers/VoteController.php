<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Content;
use App\Models\NewsItem;
use App\Models\Notification;
use App\Models\Comment;

use App\Events\NewsItemLikeNotification;
use App\Events\NewCommentLikeNotification;

class VoteController extends Controller
{
    public function update(Request $request)
    {
        Vote::where('id_user', '=', Auth::user()->id)
            ->where('id_content', '=', $request->input('content'))
            ->update(['vote' => $request->input('value')]);

        $response = [
            'action' => 'update',
            'content' => $request->input('content'),
            'vote' => $request->input('value')
        ];

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $vote = Vote::create([
            'id_user' => Auth::user()->id,
            'id_content' => $request->input('content'),
            'vote' => $request->input('value')
        ]);

        $response = [
            'action' => 'create',
            'content' => $request->input('content'),
            'vote' => $request->input('value')
        ];

        $content = Content::find($request->input('content'));
        $notification = Notification::where('id_user', '=', Auth::user()->id)
            ->where('id_content', '=', $request->input('content'))
            ->where('type', '=', 'vote')
            ->first();

        if (($news_item = NewsItem::find($request->input('content'))) !== null) {
            event(new NewsItemLikeNotification($content->id_author, $request->input('content'), $news_item->title, $notification->id, Auth::user()->id, Auth::user()->name));
        }

        if (($comment = Comment::find($request->input('content'))) !== null) {
            event(new NewCommentLikeNotification($content->id_author, $request->input('content'), $comment->news_item->title, $comment->news_item->id, Auth::user()->id, Auth::user()->name, $notification->id));
        }

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        Vote::where('id_user', '=', Auth::user()->id)
            ->where('id_content', '=', $request->input('content'))
            ->delete();

        $response = [
            'action' => 'destroy',
            'content' => $request->input('content'),
            'vote' => $request->input('value')
        ];

        return response()->json($response);
    }
}
