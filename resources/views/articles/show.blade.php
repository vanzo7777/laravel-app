@extends ('layouts.app')
@section('title', $article->title)

@section('content')

<div class="card">
    <h1>{{ $article->title }}</h1>
    <p><strong>Author:</strong>{{ $article->author }}</p>
    <p><strong>Datum:</strong>{{ $article->publish_date }}</p>

    @if($article->excerpt)
    <p><em>{{ $article->excerpt }}</em></p>
    @endif

    <hr>

    <div class="content">
        {!! nl2br(e($article->content)) !!}
    </div>
</div>

@if($article->faqs->count())
<div class="card">
    <h2>FAQ</h2>
    @foreach($article->faqs as $faq)
        <div style="margin-bottom: 20px;">
            <h3>{{ $faq->question }}</h3>
            <p>{!! nl2br(e($faq->answer)) !!}</p>
        </div>
    @endforeach
</div>
@endif


<a href="{{ route('articles.index') }}" class="btn btn-secondary">Zurück</a>

@endsection