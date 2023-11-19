<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Suggested_Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Suggested_TopicController extends Controller
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
    public function create()
    {
        //
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
    public function show(Suggested_Topic $suggested_Topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suggested_Topic $suggested_Topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Suggested_Topic $suggested_Topic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $topic)
    {
        Suggested_Topic::where('id', $topic)
        ->delete();
        return redirect()->route('manage_topic');
    }

    public function accept(string $name)
    {
        Topic::create(['name' => $name]);
        return redirect()->route('manage_topic');
    }
}
