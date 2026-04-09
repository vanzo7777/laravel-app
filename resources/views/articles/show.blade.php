@extends ('layouts.app')
@section('title', $article->title)

@section('content')

<div class="card-page">
    <div class="card__article">
        <div class="img-wrapper">
            <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
        </div>
        <h1 class="h1 card__article-title">{{ $article->title }}</h1>
        <div class="card__meta card__meta--article-page">
            <span><strong>Author:</strong>{{ $article->author }}</span>
            <span><strong>Datum:</strong>{{ $article->publish_date }}</span>
        </div>
        @if($article->excerpt)
            <p class="card__article-desc">{{ $article->excerpt }}</p>
        @endif
        <hr>
        <div class="content">
            {!! $article->content_html !!}
        </div>
    </div>

    @if($article->faqs->count())
    <div class="faq">
        <h2 class="card__article-title">FAQ</h2>
        <div class="faq__items">
            @foreach($article->faqs as $faq)
                <div class="faq__item">
                    <button class="faq__question" type="button">
                        <span class="faq__question-text">{{ $faq->question }}</span>
                        <span class="faq__icon"></span>
                    </button>

                    <div class="faq__answer-wrap">
                        <div class="faq__answer">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <a href="{{ route('articles.index') }}" class="btn btn-secondary btn-back">Zurück</a>
</div>


@endsection