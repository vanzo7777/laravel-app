@extends('layouts.app')

@section('title', 'Admin - Artikle')

@section('content')

<h1>Admin-bereich: Artikle</h1>

<div class="search search-live" data-search-url="{{ route('admin.articles.ajax.search') }}">
    <div class="search__wrapper">
        <form class="search__form" action="{{ route('admin.articles.index') }}" method="GET" autocomplete="fale">
            <input 
                type="text"
                name="search" 
                class="search__input"
                placeholder="Suche nach Artikeln..." 
                value="{{ request('search') }}"
            > 
            <div class="search-popup search-popup--admin" hidden></div>
            <button type="submit" class="btn btn-green">Suchen</button>
        </form>
    </div>
</div>

<p>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-green">+ Neuer Artikel</a>
</p>

@if($articles->count())

<table>
    <thead>
        <th>Id</th>
        <th>Title</th>
        <th>Author</th>
        <th>Datum</th>
        <th>Aktionen</th>
    </thead>
    <tbody>
        @foreach($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->author }}</td>
                <td>{{ $article->publish_date }}</td>
                <td>
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn">Bearbeiten</a>
                    <form 
                        action="{{ route('admin.articles.destroy', $article->id) }}"
                        method="POST"
                        onsubmit="return confirm('Wirklich löschen');"
                    >
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Löschen</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="card__pagination">
    {{ $articles->links() }}
</div>

@else

<p class="cart">
    Keine Artikel vorhanden
</p>

@endif

@endsection
