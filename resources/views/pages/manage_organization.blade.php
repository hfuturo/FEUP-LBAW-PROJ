@extends('layouts.app')

@section('head')
    <script type="text/javascript" src={{ url('js/organization.js') }} defer></script>
    <link href="{{ url('css/organization.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section id="manage_section">
        <h2>Members of <a href="{{route('show_org', ['organization' => $organization->id])}}"> {{ $organization->name }} </a></h2>
        <button onclick="openRequestOrg()">See new requests</button>
        <form method="POST" action="{{ route('delete_organization',  ['organization' => $organization->id]) }}">
            {{ csrf_field() }}
            <button type="submit" class="remove">Delete Organization</button>
        </form>
        @include('partials.list_requests_organization')
        <input type="hidden" id="org" name="org" value="{{ $organization->id }}">
        @foreach ($organization->members as $member)
        <article class="user_news" id="{{$member->id_user}}">
            <h4><a href="{{ route('profile', ['user' => $member->id]) }}">{{ $member->name }}</a><span class="role">({{ $member->member_type }})</span></h4>
            <p>Since: {{ \Carbon\Carbon::parse($member->joined_date) }}</p>
            @if($member->member_type !== "leader")
            <div>
                <button class="button manage expel" data-operation="expel">Expel</button>
                <button class="button manage upgrade" data-operation="upgrade">Upgrade</button>
            </div>
            @endif
        </article>
        @endforeach
    </section>
@endsection