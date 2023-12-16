@extends('layouts.app')

@section('head')
    <link href="{{ url('css/info.css') }}" rel="stylesheet">
@endsection

@section('content')
    <header class="info_header">
        <h2 class="page_title">Contact Us</h2>
        <h2>This website was developed by</h2>
    </header>
    <section class="info_section">
        <ul>
            <li><span class="info_dev">Henrique Silva</span>, <a href="mailto: up202105647@up.pt">up202105647@up.pt</a></li>
            <li><span class="info_dev">José Ribeiro</span>, <a href="mailto: up202108868@up.pt">up202108868@up.pt</a></li>
            <li><span class="info_dev">Rita Leite</span>, <a href="mailto: up202105309@up.pt">up202105309@up.pt</a></li>
            <li><span class="info_dev">Tiago Azevedo</span>, <a href="mailto: up202108699@up.pt">up202108699@up.pt</a></li>
        </ul>
    </section>
@endsection
