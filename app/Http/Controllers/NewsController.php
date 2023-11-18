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
    public function follow_list()
    {
        $this->authorize('follow_list', \App\News::class);

        // users que segue
        $following = Auth::user()
                            ->following()
                            ->get('id_following');

        // posts dos users que segue
        $posts = Content::whereIn('id_author',$following)->get();

        // obtem ids dos posts
        $ids = array();
        foreach ($posts as $post) {
            $ids[] = $post['id'];
        }

        // obtem titulos dos posts
        $titles = News_Item::whereIn('id', $ids)->get('title');

        // dá "merge" titulo do post -> post
        for ($i = 0; $i < count($posts); $i++) {
            $posts[$i]['title'] = $titles[$i]['title'];
        }

        return view('pages.news', [
            'posts' => $posts
        ]);
    }
}
