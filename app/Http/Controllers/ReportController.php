<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function show_users()
    {
        $this->authorize('show_users',\App\Report::class);

        $reports = Report::where('type','user');

        return view('pages.report_users', [
            'reports' => $reports
        ]);
    }

    public function show_news()
    {  
        $this->authorize('show_news',\App\Report::class);

        $reports = Report::join('news_item','report.id_content','=','news_item.id')
            ->select('report.*', 'news_item.id as id_news_item');
        return view('pages.report_news', [
            'reports' => $reports
        ]);
    }

    public function show_comments()
    {
        $this->authorize('show_comments',\App\Report::class);

        $reports = Report::join('comment','report.id_content','=','comment.id')
            ->select('report.*', 'comment.id as id_comment');

        return view('pages.report_comments', [
            'reports' => $reports
        ]);  
    }

    public function create_user(Request $request)
    {
        $report = Report::create([
            'reason' => $request->input('reason'),
            'type' => 'user',
            'id_reporter' => Auth::user()->id,
            'id_user'=> $request->input('user'),
        ]);
        
        return response()->json();
    }

    public function destroy(Request $request)
    {
        $this->authorize('destroy',\App\Report::class);

        $delete = Report::where('id', $request->input("request"))
            ->delete();
        $response = [
            'action' => 'delete_report',
            'id' => $request->input("request"),
        ];
        
        return response()->json($response);
    }
}