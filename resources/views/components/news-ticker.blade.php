@php
    $articles = \App\Models\Article::published()->latest()->take(3)->get();
@endphp

@if ($articles->count() > 0)
    <div class="container-fluid p-0 pt-1 bg-light border-bottom" id="news">
        <div class="conainter-marquee w-100">
            <marquee class="news-scroll py-2 ls-2" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                @foreach ($articles as $article)
                    <a href="{{ route('about.articles.show', $article) }}" class="link-no-underline mr-3">{{ $article->title }}</a>
                @endforeach
            </marquee>
        </div>
        <a href="#close" class="d-block icon-close p-2 link-no-underline border-bottom-0" id="hide-news"></a>
    </div>
@endif
