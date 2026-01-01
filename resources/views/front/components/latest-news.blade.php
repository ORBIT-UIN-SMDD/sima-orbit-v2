@php

    $latest_news = App\Models\News::latest()
        ->with(['category', 'user', 'viewers', 'comments'])
        ->where('status', 'published')
        ->limit(4)
        ->get();
@endphp
<div class="mb-15 md-mb-50px xs-mb-35px">
    <div
        class="fw-600 fs-19 lh-22 ls-minus-05px text-dark-gray border-bottom border-color-dark-gray border-2 d-block mb-30px pb-15px position-relative">
        Berita Terbaru</div>
    <ul class="popular-post-sidebar position-relative">
        @foreach ($latest_news as $latest)
        <li class="d-flex align-items-center">
            <figure>
                <a href="{{ route('news.show', $latest->slug) }}"><img src="{{ $latest->getThumbnail() }}"
                        alt=""></a>
            </figure>
            <div class="col media-body">
                <a href="{{ route('news.show', $latest->slug) }}"
                    class="fw-600 fs-17 text-dark-gray d-inline-block mb-10px">{{ Str::limit($latest->title, 50) }}</a>
                <div><a href="blog-grid.html" class="d-inline-block fs-15">{{ $latest->created_at->diffForHumans() }}</a></div>
            </div>
        </li>
        @endforeach
    </ul>
</div>

