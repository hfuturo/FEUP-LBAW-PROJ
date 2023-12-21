@extends('layouts.app')

@section('head')
    <script type="text/javascript" src={{ url('js/report.js') }} defer></script>
@endsection

@section('content')
    <h2>Manage News' Reports</h2>
    <section id="list_reports">
        <h3>List of the reports ...</h3>  
        @if ($reports->get()->isEmpty())
            <p>There are no reports to show.</p>
        @else
            @foreach ($reports->paginate(5) as $report)
                <article id="{{ $report->id }}" class="info_article">
                    <h4 class="{{ $report->id_content }}">
                        Title:
                        <a href="{{ route('news_page', ['id' => $report->content->id]) }}">
                            {{ $report->content->news_items->title }}
                        </a>
                    </h4>
                    <p>
                        Author:
                        <a href="{{ route('profile', ['user' => $report->id_reporter]) }}"> {{ $report->reporter->name }}</a>
                    </p>
                    <p>Justification: {{ $report->reason }}</p>
                    <div class="container_choices">
                        <button class="accept action_report" data-operation="delete_report">Ignore Report</button>
                        <button class="remove action_report" data-operation="delete_news_item">Delete News'Item</button>
                    </div>
                </article>
            @endforeach
        @endif
        <span>{{ $reports->paginate(5)->links() }}</span>
    </section>
@endsection
