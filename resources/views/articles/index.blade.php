@extends('layouts.app')
@section('title', 'Alle Artikle')
@section('content')

<h1>Alle Artikle</h1>


<div class="card__wrapper">
    @forelse($articles as $article)
        <div class="card__item">
            <a href="{{ route('articles.show', $article->id) }}">
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
            </a>  
            <a href="{{ route('articles.show', $article->id) }}" class="card__title">{{ $article->title }}</a>
            <div class="card__meta">
                <span><strong>Author:</strong>{{ $article->author }}</span>
                <span><strong>Datum:</strong>{{ $article->publish_date }}</span>
            </div>
            <p class="card__excerpt">{{ $article->short_excerpt }}</p>
            <a href="{{ route('articles.show', $article->id) }}" class="btn card__button">
                Mehr lesen
            </a>
        </div>
        @empty
        <div class="card">
            <p>Es sind noch keine Artikel vorhanden.</p>
        </div>
    @endforelse
</div>

@endsection