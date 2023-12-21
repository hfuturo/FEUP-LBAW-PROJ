@extends('layouts.app')

@section('head')
    <script type="text/javascript" src={{ url('js/report.js') }} defer></script>
@endsection

@section('content')
    <h2>Manage Comments' Reports</h2>
    <section id="list_reports">
        <h3>List of the reports ...</h3>
        @if ($reports->get()->isEmpty())
            <p>There are no reports to show.</p>
        @else
            @foreach ($reports->paginate(5) as $report)
                <article id="{{ $report->id }}" class="info_article">
                    <h4 class="{{ $report->id_content }}">Comment:</h4>
                    <p>{{ $report->content->content }}</p>
                    <p>Author: <a href="{{ route('profile', ['user' => $report->id_reporter]) }}">
                            {{ $report->reporter->name }}</a></p>
                    <p>Justification: {{ $report->reason }}</p>
                    <p>Can be found in:
                        <a href="{{ route('news_page', ['id' => $report->content->comments->id_news]) }}">
                            {{ $report->content->comments->news_item->title }}
                        </a>
                    </p>
                    <div class="container_choices">
                        <button class="accept action_report" data-operation="delete_report">Ignore Report</button>
                        <button class="remove action_report" data-operation="delete_comment">Delete Comment</button>
                    </div>
                </article>
            @endforeach
        @endif
        <span>{{ $reports->paginate(5)->links() }}</span>
    </section>
@endsection
