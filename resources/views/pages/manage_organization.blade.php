@extends('layouts.app')

@section('head')
    <script type="text/javascript" src={{ url('js/organization.js') }} defer></script>
@endsection

@section('content')
    <section>
    <input type="hidden" id="org" name="org" value="{{ $organization->id }}">
    @foreach ($organization->members as $member)
    <article class="user_news" id="{{$member->id_user}}">
        <h4><a href="{{ route('profile', ['user' => $member->id]) }}">{{ $member->name }}</a><span class="role">({{ $member->member_type }})</span><h4>
        <p>Since: {{ \Carbon\Carbon::parse($member->joined_date) }}</p>
        @if($member->member_type !== "leader")
        <button class="button manage expel" data-operation="expel">Expel</button>
        <button class="button manage upgrade" data-operation="upgrade">Upgrade</button>
        @endif
    </article>
    @endforeach
    </section>
@endsection