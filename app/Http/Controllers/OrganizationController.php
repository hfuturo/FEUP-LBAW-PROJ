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
                'name_org' => 'required|unique:organization,name|max:255|string',
                'bio_org' => 'required|string',
            ]);

            $result = DB::transaction(function () use ($request) {
                $org = new Organization();
                $org->name = $request->input('name_org');
                $org->bio = $request->input('bio_org');
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

    public function show_manage(int $id)
    {
        $org = Organization::findOrFail($id);
        $this->authorize('show_manage', $org);

        return view('pages.manage_organization', ['organization' => $org]);
    }


    public function update(Request $request)
    {
        $organization = Organization::find($request->input('orgId'));

        $this->authorize('update', $organization);

        if($organization->name === $request->input('name')){
            $valid = $request->validate(['bio' => 'required|string',]);   
            if($valid){
                $update = $organization->update(['bio' => $request->input('bio')]);         
                return back()->with('success', 'Successfully Create!');
            }
        }
        else{
            $valid = $request->validate([
                'name' => 'required|unique:organization,name|max:255|string',
                'bio' => 'required|string',
            ]);
            if($valid){
                $update = $organization->update(['name' => $request->input('name'), 'bio' => $request->input('bio')]);     
                return back()->with('success', 'Successfully Create!');
            }    
        }
        return back()->withErrors(['error' => 'There was a problem']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $organization)
    {
        try{
            $org = Organization::find($organization);
            $this->authorize('destroy', $org);
            $org->delete();
            return redirect()->route('news')->with('success', 'You have successfully deleted your organization!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'You were not able to delete this organization, please check your permissions or try to refresh the page']);
        }
    }
}
