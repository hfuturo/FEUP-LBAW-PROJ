<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
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
}
