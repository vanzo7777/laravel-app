@extends('layouts.app')
@section('title', 'Alle Artikle')
@section('content')

<h1>Alle Artikle</h1>

@forelse($articles as $article)
<div class="card">
    <h2>{{ $aticle->title }}</h2>
    <p><strong>Author:</strong>{{ $article->author }}</p>
    <p><strong>Datum:</strong>{{ $article->publish_date }}</p>
    <p>{{ $article->excerpt }}</p>
    <a href="{{ route('articles.show', $article->id) }}" class="btn">
        Mehr lesen
    </a>
</div>
@empty
<div class="card">
    <p>Es sind noch keine Artikel vorhanden.</p>
</div>

@endforelse
@endsection