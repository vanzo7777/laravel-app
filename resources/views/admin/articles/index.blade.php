@extends('layouts.app')

@section('title', 'Admin - Artikle')

@section('content')

<h1>Admin-bereich: Artikle</h1>

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

@else

<p class="cart">
    Keine Artikel vorhanden
</p>

@endif

@endsection
