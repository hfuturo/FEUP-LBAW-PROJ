<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function show_users()
    {
        $this->authorize('show_users', \App\Report::class);

        $reports = Report::where('type', 'user');

        return view('pages.report_users', [
            'reports' => $reports
        ]);
    }

    public function show_news()
    {
        $this->authorize('show_news', \App\Report::class);
        if(Auth::user()->type === "admin"){
            $reports = Report::join('news_item', 'report.id_content', '=', 'news_item.id')
                ->select('report.*', 'news_item.id as id_news_item');
        }
        else if(Auth::user()->type === "moderator"){
            $reports = Report::join('news_item', 'report.id_content', '=', 'news_item.id')
                ->where('news_item.id_topic','=',Auth::user()->id_topic)
                ->select('report.*', 'news_item.id as id_news_item');
        }
        return view('pages.report_news', [
            'reports' => $reports
        ]);
    }

    public function show_comments()
    {
        $this->authorize('show_comments', Report::class);
        if(Auth::user()->type === "admin"){
            $reports = Report::join('comment', 'report.id_content', '=', 'comment.id')
                ->select('report.*', 'comment.id as id_comment');
        }
        else if(Auth::user()->type === "moderator"){
            $reports = Report::join('comment', 'report.id_content', '=', 'comment.id')
            ->join('news_item','comment.id_news','=','news_item.id')
            ->where('news_item.id_topic','=',Auth::user()->id_topic)
            ->select('report.*', 'comment.id as id_comment');

        }
        return view('pages.report_comments', [
            'reports' => $reports
        ]);
    }


    public function create_user(Request $request)
    {
        try{
            $request->validate([
                'id_reported' => 'required|numeric',
                'reason' => 'required|string',
            ]);
            
            $report = Report::create([
                'reason' => $request->input('reason'),
                'type' => 'user',
                'id_reporter' => Auth::user()->id,
                'id_user' => $request->input('id_reported'),
            ]);
            return redirect()->back()->with('success', 'Successfully changed!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return response()->json();
    }

    public function create_content(Request $request)
    {
        try {
            $request->validate([
                'reason' => 'required|string',
                'id_content' => 'required',
            ]);

            Report::create([
                'reason' => $request->input('reason'),
                'type' => 'content',
                'id_reporter' => Auth::user()->id,
                'id_content' => $request->input('id_content'),
            ]);
            return response()->json(['success' => 'Report created successfully'], 200);
        } catch (AuthorizationException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function destroy(Request $request)
    {
        $report = Report::find($request->input("request"));

        $this->authorize('destroy', $report);

        $delete = Report::where('id', $request->input("request"))
            ->delete();
        $response = [
            'action' => 'delete_report',
            'id' => $request->input("request"),
        ];

        return response()->json($response);
    }
}
