@extends('layouts.app')

@section('title', 'Artikle bearbeiten')


@section('content')


<div class="card__admin">
    <h1>Artikle bearbeiten</h1>
    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="input-wrapper">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}">
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-wrapper">
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $article->slug) }}">
            @error('slug')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-wrapper">
            <label for="excerpt">Kurzbeschreibung</label>
            <textarea name="excerpt" id="excerpt" row="3">{{ old('excerpt', $article->excerpt) }}</textarea>
            @error('excerpt')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-wrapper">
            <label for="content">Inhalt</label>
            <textarea name="content" id="content" rows="8">{{ old('content', $article->content) }}</textarea>
            @error('content')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-wrapper">
            <label for="publish_date">Veröffentlichungsdatum</label>
            <input type="text" name="publish_date" id="publish_date" value="{{ old('publish_date', $article->publish_date) }}">
            @error('publish_date')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-wrapper">
            <label for="author">Autor</label>
            <input type="text" name="author" id="author" value="{{ old('author', $article->author) }}">
            @error('author')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-wrapper">
            <label for="sort_order">Sort order</label>
            <input type="text" name="sort_order" id="sort_order" value="{{ old('sort_order', $article->sort_order) }}">
            @error('sort_order')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


        <div class="input-wrapper">
            <label for="image">Bild</label>
            <input type="file" name="image" id="image" accept="image/*">
            @error('image')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="img-preview">
            @if($article->image)
                <p>Aktuelles Bild:</p>
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" style="max-width: 250px; border-radius: 8px; margin-bottom: 15px;">
            @endif
        </div>
        <div class="faq__wrapper">
            @for($i = 0; $i < 4; $i++)
            @php
                $faq = $article->faqs[$i] ?? null;
            @endphp
            <div class="faq__questions">
                <label> Frage {{ $i + 1 }}</label>
                <input 
                    type="text"
                    name="faqs[{{ $i }}][question]"
                    value="{{ old('faqs.$i.question', $faq->question ?? '') }}"
                >
                @error('faqs.$i.question')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="faq__answer">
                <label>Antwort {{ $i + 1 }}</label>
                <input 
                    type="text"
                    name="faqs[{{ $i }}][answer]"
                    value="{{ old('faqs.$i.answer', $faq->answer ?? '') }}"
                >
                @error('faqs.$i.answer')
                    <div class="error">{{ message }}</div>
                @enderror
            </div>
            @endfor
        </div>
        <div class="button-wrapper">
            <button class="btn" type="submit">Aktualisiert</button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary"> Zurück</a>
        </div>
    </form>
</div>


@endsection