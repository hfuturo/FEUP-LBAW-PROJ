@extends('layouts.app')

@section('head')
    <link href="{{ url('css/organization.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/organization.js') }} defer></script>
@endsection

@section('content')
    <section id="org_info">
        <div class="header">
            <h3>{{ $organization->name }}</h3>
            <div>
                <?php $follow_org = Auth::user()->follow_organizations()->where('id_organization', $organization->id)->first();?>
                <input type="hidden" id="following" name="id_following" value="{{ $organization->id }}">
                @if ($follow_org)
                    <button id="follow" data-operation="unfollow">Unfollow</button>
                @else
                    <button id="follow" data-operation="follow">Follow</button>
                @endif
                <button class="button" onclick="">Join</button>
            </div>
        </div>
        <p>{{ $organization->bio }}</p>
        <div id="followers_members">
            <button class="button"><span>Followers </span><span>{{ $organization->followers->count() }}</span></button>
            <button class="button" onclick="openMembersOrg()"><span>Members </span><span>{{ $organization->members->count() }}</span></button>
            @include('partials.organization_members')
        </div>
    </section>
    <section id="org_feed">
        @if ($organization->contents()->get()->isEmpty())
            <p>There is no news releted to this organization</p>
        @else
            @include('partials.list_news', ['news_list' => $organization->contents(), 'perPage' => 5])
        @endif
    </section>
@endsection
