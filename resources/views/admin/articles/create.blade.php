@extends('layouts.app')

@section('title', 'Artikel erstellen')

@section('content')

<div class="card__admin">
    <h1>Neuen Artikel erstellen</h1>
    <form 
        action="{{ route('admin.articles.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="input-wrapper">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
         </div>

        <div class="input-wrapper">
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}">
            @error('slug')
                <div class="error">{{ $message }}</div>
            @enderror
         </div>

        <div class="input-wrapper">
            <label for="excerpt"> Kurzbeschreibung </label>
            <textarea name="excerpt" id="excerpt" rows="3">{{ old('excerpt') }}</textarea>
            @error('excerpt')
                <div class="error">{{ $message }}</div>
            @enderror
         </div>

         <div class="input-wrapper">
            <label for="content">Inhalt</label>
            <textarea name="content" id="content" rows="8">{{ old('content') }}</textarea>
            @error('content')
               <div class="error">{{ $message }}</div> 
            @enderror
         </div>

         <div class="input-wrapper">
            <label for="publish_date">Veröffentlichungsdatum</label>
            <input type="date" name="publish_date" id="publish_date" value="{{ old('publish_date') }}">
            @error('publish_date') 
               <div class="error">{{ $message }}</div> 
            @enderror
         </div>

         <div class="input-wrapper">   
            <label for="author">Autor</label>
            <input type="text" name="author" id="author" value="{{ old('author') }}">
            @error('author')
               <div class="error">{{ $message }}</div> 
            @enderror
         </div>

         <div class="input-wrapper">   
            <label for="sort_order">Sort order</label>
            <input type="text" name="sort_order" id="sort_order" value="{{ old('sort_order') }}">
            @error('sort_order')
               <div class="error">{{ $message }}</div> 
            @enderror
         </div>

         <div class="input-wrapper">
            <label for="image">Bild</label>
            <input type="file" id="image" name="image" accept="image/*">
            @error('image')
                <div class="error">{{ $message }}</div>
            @enderror
         </div>

         <h3>FAQ</h3>

         <div class="faq__wrapper">
            @for($i = 0; $i < 4; $i++)
                <div class="faq__questions">
                    <label> Frage {{ $i + 1 }}</label>
                    <input type="text" name="faqs[{{ $i }}][question]" value="{{ old('faqs.$i.question') }}">
                    @error('faqs.$i.question')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="faq__answer">
                    <label>Antwort {{ $i + 1 }}</label>
                    <input type="text" name="faqs[{{ $i }}][answer]" value="{{ old('faqs.$i.answer') }}">
                    @error('faqs.$i.answer')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            @endfor
         </div>
        
        <div class="buttons-wrapper">
            <button type="submit" class="btn">Speichern</button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Zurück</a>
        </div>     
        
    </form>
</div>

@endsection