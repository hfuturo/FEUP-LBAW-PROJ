@extends('layouts.app')

@section('content')

<section class="info_section">
    <header class="info_header">
        <h1>NewsCore</h1>
        <h2>About Us</h2>
    </header>
    <p class="about_text">
        The increase of misinformation and complexity of websites is one of the main problems that everyone faces on the internet. With that in mind, we decided to create NewsCore. NewsCore is a software being developed by a group of FEUP students for people who want to read, write, and share news on various topics in an organized and simple way.
    </p>
    <p>
        The main goal of this project is to develop a computer system with a web interface for a collaborative news management platform that can be used by anyone, which means that anybody can create an account and post what they want to share.
    </p>
</section>
<section class="main_features">
    <header class="info_header">
        <h2>Main Features</h2>
    </header>
    <ul>
        <li>Read a news item</li>
        <li>Read comments associated to a news item</li>
        <li>Write a news item</li>
        <li>(Un)follow users</li>
        <li>News feed with all the news items posted by people you follow</li>
        <li>News feed with all the top news</li>
        <li>News feed with all the News Items ordered chronologically</li>
    </ul>
</section>


@endsection