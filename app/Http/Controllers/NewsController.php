<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\News_Item;
use App\Models\User;
use App\Models\Content;

class NewsController extends Controller
{
    public function list_default_feed() {
        return view('pages.news');
    }
    
    public function follow_list(Request $request)
    {
        $this->authorize('follow_list', \App\News::class);

        // users que segue
        $following = Auth::user()->following()->get('id_following');

        $all_news = News_Item::all('id');

        $now = Carbon::now();

        // posts dos users que segue por ordem DESC
        $posts = Content::whereIn('id_author',$following)->whereIn('id',$all_news)->orderBy('date','DESC')->paginate(10);

        // obtem titulos dos posts
        for ($i = 0; $i < count($posts); $i++) {
            $news = News_Item::where('id', $posts[$i]['id'])->get();
            $posts[$i]['title'] = $news[0]['title'];
            $posts[$i]['seconds'] = $now->diffInSeconds($posts[$i]['date']);
            $posts[$i]['minutes'] = $now->diffInMinutes($posts[$i]['date']);
            $posts[$i]['hours'] = $now->diffInHours($posts[$i]['date']);
            $posts[$i]['days'] = $now->diffInDays($posts[$i]['date']);
            $posts[$i]['weeks'] = $now->diffInWeeks($posts[$i]['date']);
            $posts[$i]['months'] = $now->diffInMonths($posts[$i]['date']);
            $posts[$i]['years'] = $now->diffInYears($posts[$i]['date']);
        }

        return response()->json([
            'posts' => $posts,
            'links' => (string)$posts->links()
        ]);
    }

    public function recent_list(Request $request)
    {
        $all_news = News_Item::all('id');
        $posts = Content::whereIn('id',$all_news)->orderBy('date','DESC')->paginate(10);

        $now = Carbon::now();

        for ($i = 0; $i < count($posts); $i++) {
            $news = News_Item::where('id', $posts[$i]['id'])->get();
            $posts[$i]['title'] = $news[0]['title'];
            $posts[$i]['seconds'] = $now->diffInSeconds($posts[$i]['date']);
            $posts[$i]['minutes'] = $now->diffInMinutes($posts[$i]['date']);
            $posts[$i]['hours'] = $now->diffInHours($posts[$i]['date']);
            $posts[$i]['days'] = $now->diffInDays($posts[$i]['date']);
            $posts[$i]['weeks'] = $now->diffInWeeks($posts[$i]['date']);
            $posts[$i]['months'] = $now->diffInMonths($posts[$i]['date']);
            $posts[$i]['years'] = $now->diffInYears($posts[$i]['date']);
        } 

        return response()->json([
            'posts' => $posts,
            'links' => (string)$posts->links()
        ]); 
    }
}
