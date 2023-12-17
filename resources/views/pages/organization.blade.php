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
                <button class="Button" onclick="">Follow</button>
                <button class="Button" onclick="">Join</button>
            </div>
        </div>
        <p>{{ $organization->bio }}</p>
        <div id="followers_members">
            <a href=""><span>Followers</span><span>{{ $organization->followers->count() }}</span></a>
            <button class="Button" onclick="openMembersOrg()"><span>Members </span><span>{{ $organization->members->count() }}</span></a></button>
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
