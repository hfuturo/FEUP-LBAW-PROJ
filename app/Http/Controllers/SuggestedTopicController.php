<?php

namespace App\Http\Controllers;

use App\Models\SuggestedTopic;
use App\Models\Topic;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestedTopicController extends Controller
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
    public function create(Request $request)
    {
        $this->authorize('create', \App\SuggestedTopic::class);
        $valid = $request->validate([
            'name_topic' => 'string|unique:topic,name',
            'justification_topic' => 'nullable|string',
        ]);
        if ($valid) {
            SuggestedTopic::create([
                'name' => $request->input('name_topic'),
                'justification' => empty($request->input('justification_topic')) ? '' : $request->input('justification_topic'),
                'id_user' => Auth::user()->id,
            ]);

            return back()->with('success', 'Successfully Create!');
        }
        return back()->withErrors(['error' => 'There was a problem']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SuggestedTopic $suggested_Topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuggestedTopic $suggested_Topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuggestedTopic $suggested_Topic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('destroy', \App\SuggestedTopic::class);
        $idTopic = $request->input('idTopic');
        SuggestedTopic::where('id', $idTopic)->delete();
        return response()->json($idTopic);
    }

    public function accept(Request $request)
    {
        $this->authorize('accept', \App\SuggestedTopic::class);
        $idTopic = $request->input('idTopic');
        $name = SuggestedTopic::find($idTopic)->name;
        SuggestedTopic::where('id', $request->input('idTopic'))->delete();
        Topic::create(['name' => $name]);
        return response()->json($idTopic);
    }
}
