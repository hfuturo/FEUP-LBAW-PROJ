<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\News_Item;
use App\Models\User;
use App\Models\Content;

class NewsController extends Controller
{
    public function show() {
        return view('pages.news');
    }
    
    public function follow_list(Request $request)
    {
        $this->authorize('follow_list', \App\News::class);

        // users que segue
        $following = Auth::user()
                            ->following()
                            ->get('id_following');

        // posts dos users que segue por ordem DESC
        $posts = Content::whereIn('id_author',$following)->orderBy('date','DESC')->paginate(5);

        // obtem titulos dos posts
        for ($i = 0; $i < count($posts); $i++) {
            $title = News_Item::where('id', $posts[$i]['id'])->get('title');
            $posts[$i]['title'] = $title[0]['title'];
        }

        return response()->json([
            'posts' => $posts,
            'links' => (string)$posts->links()
        ]);
    }
}
