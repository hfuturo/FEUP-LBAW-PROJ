<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use App\Models\MembershipStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|unique:organization,name|max:255|string',
                'bio' => 'required|string',
            ]);

            $result = DB::transaction(function () use ($request) {
                $org = new Organization();
                $org->name = $request->input('name');
                $org->bio = $request->input('bio');
                $org->save();
                $org = $org->refresh();


                $leader = new MembershipStatus();
                $leader->id_organization = $org->id;
                $leader->id_user = Auth::user()->id;
                $leader->joined_date= 'now()';
                $leader->member_type='leader';
                $leader->save();

                return $org;

            });
            return redirect()->route('show_org', ['organization' => $result->id]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $org = Organization::findOrFail($id);

        return view('pages.organization', ['organization' => $org]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
