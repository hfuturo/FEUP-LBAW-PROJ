<?php

namespace App\Http\Controllers;

use App\Models\SuggestedTopic;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestedTopicController extends Controller
{
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

    public function show()
    {
        $this->authorize('show_suggested_topic', \App\Manage::class);
        $suggested_topic = SuggestedTopic::join('authenticated_user', 'suggested_topic.id_user', '=', 'authenticated_user.id')
            ->select('suggested_topic.*', 'authenticated_user.name as user_name');
        return view('pages.manage_topic', [
            'suggested_topic' => $suggested_topic
        ]);
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
