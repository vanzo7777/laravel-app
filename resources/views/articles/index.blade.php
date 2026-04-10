@extends('layouts.app')
@section('title', 'Alle Artikle')
@section('content')

<h1>Alle Artikle</h1>

<div class="search search-live" data-search-url="{{ route('articles.ajax.search') }}">
    <div class="search__wrapper">
        <form class="search__form" action="{{ route('articles.index') }}" method="GET" autocomplete="off">
            <input 
                type="text" 
                name="search"
                class="search__input"
                placeholder="Suche nach Artikeln..." 
                value="{{ request('search') }}"
            >
            <button type="submit" class="btn btn-green">Suchen</button>
        </form>
        <div class="search-popup" hidden></div>
    </div>
</div>


<div class="card__wrapper">
    @forelse($articles as $article)
        <div class="card__item">
            <a href="{{ route('articles.show', $article->slug) }}">
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
            </a>  
            <a href="{{ route('articles.show', $article->slug) }}" class="card__title">{{ $article->title }}</a>
            <div class="card__meta">
                <span><strong>Author:</strong>{{ $article->author }}</span>
                <span><strong>Datum:</strong>{{ $article->publish_date }}</span>
            </div>
            <p class="card__excerpt">{{ $article->short_excerpt }}</p>
            <a href="{{ route('articles.show', $article->slug) }}" class="btn card__button">
                Mehr lesen
            </a>
        </div>
        @empty
        <div class="card__item">
            <p class="card__title">Es sind noch keine Artikel vorhanden.</p>
        </div>
    @endforelse
</div>

<div class="card__pagination">
    {{ $articles->links() }}
</div>

@endsection