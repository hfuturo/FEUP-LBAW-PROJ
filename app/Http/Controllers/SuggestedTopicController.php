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
        $validator = $request->validate([
            'name' => 'string|unique:suggested_topic|unique:topic',
            'justification' => 'nullable|string',
        ]);
        if ($validator) {
            SuggestedTopic::create([
                'name' => $request->input('name'),
                'justification' => empty($request->input('justification')) ? '' : $request->input('justification'),
                'id_user' => Auth::user()->id,
            ]);
        }
        return back();
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
    public function destroy(int $topic)
    {
        $this->authorize('destroy', \App\SuggestedTopic::class);
        try {
            SuggestedTopic::where('id', $topic)->delete();
        } catch (Exception $e) {
        }
        return redirect()->route('manage_topic');
    }

    public function accept(string $name)
    {
        try {
            $this->authorize('accept', \App\SuggestedTopic::class);
            Topic::create(['name' => $name]);
        } catch (Exception $e) {
        }
        return redirect()->route('manage_topic');
    }
}
