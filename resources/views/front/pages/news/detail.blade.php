@extends('front.app')

@section('seo')
<title>{{ $meta['description'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('news.show', $news->slug) }}">
    <link rel="canonical" href="{{ route('news.show', $news->slug) }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('styles')
@endsection

@section('content')
    <!-- start page title -->
    <section class="ipad-top-space-margin bg-dark-gray cover-background one-fifth-screen d-flex align-items-center"
        style="background-image: url({{ $news->getThumbnail() }})">
        <div class="background-position-center-top h-100 w-100 position-absolute left-0px top-0"
            style="background-image: url('images/vertical-line-bg-small.svg')"></div>
        <div id="particles-style-01" class="h-100 position-absolute left-0px top-0 w-100" data-particle="true"
            data-particle-options='{"particles": {"number": {"value": 12,"density": {"enable": true,"value_area": 2000}},"color": {"value": ["#d5d52b", "#d5d52b", "#d5d52b", "#d5d52b", "#d5d52b"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 1,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"line_linked":{"enable":false,"distance":0,"color":"#ffffff","opacity":1,"width":1},"move": {"enable": true,"speed":1,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}'>
        </div>
        <div class="opacity-light bg-dark-gray"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 position-relative"
                    data-anime='{ "el": "childs", "opacity": [0, 1], "translateX": [50, 0], "staggervalue": 100, "easing": "easeOutQuad" }'>
                    <div class="d-inline-block mb-20px sm-mb-25px">
                        <span class="text-white fs-18 opacity-5">
                            <a href="demo-elearning-blog.html"
                                class="text-white">{{ $news->created_at->format('d M Y') }}</a>
                            <span class="d-inline-block fs-24 align-top ms-10px me-10px">•</span>
                            <a href="demo-elearning-blog.html" class="text-white">{{ $news->category?->name }}</a>
                        </span>
                    </div>
                    <h1
                        class="text-white w-60 lg-w-80 md-w-70 sm-w-100 fw-500 ls-minus-2px text-white alt-font mb-30px overflow-hidden mb-0">
                        {{ $news->title }}</h1>
                    <div class="text-white fs-18 mt-40px">
                        <img class="w-80px h-80px rounded-circle me-15px" src="{{ $news->user->getPhoto() }}"
                            alt="">
                        <a href="demo-elearning-blog.html"
                            class="text-white text-decoration-line-bottom">{{ $news->user?->name }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end page title -->
    <!-- start section -->

    <section class="pb-0">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 blog-standard md-mb-50px sm-mb-40px">

                    <div class="col-12 mb-40px">
                        <div class="row justify-content-center">

                            <p>
                                {!! $news->content !!}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- start sidebar -->
                <aside class="col-12 col-xl-4 col-lg-4 col-md-7 ps-55px xl-ps-50px lg-ps-15px sidebar">
                    <div class="mb-15 md-mb-50px xs-mb-35px">
                        <div
                            class="fw-600 fs-19 lh-22 ls-minus-05px text-dark-gray border-bottom border-color-dark-gray border-2 d-block mb-20px pb-10px position-relative">
                            Pencarian Berita
                        </div>

                        <form method="GET"
                            action="{{ request()->routeIs('news.category') ? route('news.category', ['slug' => $category->slug]) : route('news.index') }}">
                            <div class="input-group mb-10px">
                                <input type="text" name="q" class="form-control" placeholder="Cari berita..."
                                    value="{{ request('q') }}">
                                <button type="submit" class="btn btn-dark-gray">
                                    <i class="feather icon-feather-search"></i>
                                </button>
                            </div>

                        </form>
                    </div>
                    @include('front.components.latest-news')
                    @include('front.components.news-categories')
                    @include('front.components.news-subscribe')

                </aside>
                <!-- end sidebar -->
            </div>
        </div>
    </section>
    <!-- end section -->
    <!-- start section -->
    <section class="half-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row mb-30px">
                        <div class="tag-cloud col-md-9 text-center text-md-start sm-mb-15px">
                            @php
                                $tags = explode(',', $news->meta_keywords ?? '');
                            @endphp
                            @foreach ($tags ?? [] as $tag)
                                <a href="#">{{ $tag }}</a>
                            @endforeach
                        </div>
                        <div class="tag-cloud col-md-3 text-uppercase text-center text-md-end">
                            <a class="likes-count fw-500 mx-0" href="#"><i
                                    class="fa-regular fa-eye text-red me-10px"></i><span
                                    class="text-dark-gray text-dark-gray-hover">{{ $news->viewers->count() ?? 0 }}
                                    Views</span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-6">
                            <div
                                class="d-block d-md-flex w-100 box-shadow-extra-large align-items-center border-radius-4px p-7 sm-p-35px">
                                <div class="w-140px text-center me-50px sm-mx-auto">
                                    <img src="{{ $news->user->getPhoto() }}" class="rounded-circle w-120px"
                                        alt="">
                                    <a href="demo-elearning-blog.html"
                                        class="text-dark-gray fw-500 mt-20px d-inline-block lh-20">{{ $news->user->name ?? '-' }}</a>
                                    <span
                                        class="fs-15 lh-20 d-block sm-mb-15px">{{ $news->user->position ?? '-' }}</span>
                                </div>
                                <div class="w-75 sm-w-100 text-center text-md-start last-paragraph-no-margin">
                                    <p>
                                        {{ \Illuminate\Support\Str::limit(strip_tags($news->user->about ?? '-'), 150) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="row justify-content-center">
                                <div class="col-12 text-center elements-social social-icon-style-04">
                                    <div class="mb-3">
                                        <span class="fw-600 fs-16 text-dark-gray">Share</span>
                                    </div>
                                    <ul class="medium-icon dark">
                                        <li>
                                            <a class="facebook"
                                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('news.show', $news->slug)) }}"
                                                target="_blank" rel="noopener">
                                                <i class="fa-brands fa-facebook-f"></i><span></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="twitter"
                                                href="https://twitter.com/intent/tweet?url={{ urlencode(route('news.show', $news->slug)) }}&text={{ urlencode($news->title) }}"
                                                target="_blank" rel="noopener">
                                                <i class="fa-brands fa-twitter"></i><span></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="whatsapp"
                                                href="https://wa.me/?text={{ urlencode($news->title . ' ' . route('news.show', $news->slug)) }}"
                                                target="_blank" rel="noopener">
                                                <i class="fa-brands fa-whatsapp"></i><span></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="linkedin"
                                                href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('news.show', $news->slug)) }}&title={{ urlencode($news->title) }}"
                                                target="_blank" rel="noopener">
                                                <i class="fa-brands fa-linkedin-in"></i><span></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="email"
                                                href="mailto:?subject={{ urlencode($news->title) }}&body={{ urlencode(route('news.show', $news->slug)) }}"
                                                target="_blank" rel="noopener">
                                                <i class="fa-solid fa-envelope"></i><span></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
    <!-- start section -->
    @if ($related_news->count() > 0)
        <section class="bg-tranquil" style=" background-color: #f3f8f8;">
            <div class="container">
                <div class="row justify-content-center mb-1">
                    <div class="col-lg-7 text-center">
                        <span class="alt-font text-dark-gray fs-19 fw-500 mb-5px d-inline-block ls-minus-05p">Mungkin Anda
                            Juga Suka</span>
                        <h2 class="alt-font text-dark-gray fw-600 ls-minus-3px">Berita Terkait</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 px-0 xs-ps-15px xs-pe-15px">
                        <ul class="blog-masonry blog-wrapper grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-1col xs-grid-1col gutter-extra-large"
                            data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                            <li class="grid-sizer"></li>
                            @foreach ($related_news as $related)
                                <li class="grid-item">
                                    <div
                                        class="card border-0 border-radius-4px overflow-hidden box-shadow-large box-shadow-extra-large-hover">
                                        <div class="card-top d-flex align-items-center">
                                            <a href="demo-elearning-blog.html"><img
                                                    src="{{ $related->user?->getPhoto() }}" class="avtar"
                                                    alt=""></a>
                                            <span class="fs-16">By <a href="demo-elearning-blog.html"
                                                    class="text-dark-gray fw-600">{{ $related->user?->name }}</a></span>
                                            <div class="like-count ms-auto fs-14">
                                                <a href="#"><i
                                                        class="fa-regular fa-eye text-red d-inline-block"></i><span
                                                        class="text-dark-gray fw-600">{{ $related->viewers->count() }}</span></a>
                                            </div>
                                        </div>
                                        <div class="blog-image position-relative overflow-hidden">
                                            <a href="demo-elearning-blog-single-simple.html"><img
                                                    src="{{ $related->getThumbnail() }}" alt="" /></a>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="post-content p-11 md-p-9">
                                                <a href="demo-elearning-blog-single-simple.html"
                                                    class="card-title mb-10px fw-600 fs-19 lh-28 text-dark-gray d-inline-block">
                                                    {{ $related->title }}
                                                </a>
                                                <p class="mb-0">
                                                    {{ strip_tags(Str::limit($related->content, 100)) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- end section -->
    <!-- start section -->
    <section style="padding-top: 30px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 text-center ">
                    <h5 class="alt-font text-dark-gray fw-600 ls-minus-05px">{{ $comments->count() }} Komentar
                    </h5>
                </div>
            </div>
            @if ($comments->count() > 0)
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <ul class="blog-comment">
                            @foreach ($comments as $comment)
                                <li>
                                    <div class="d-block d-md-flex w-100 align-items-center align-items-md-start ">
                                        <div class="w-90px sm-w-65px sm-mb-10px">
                                            <img src="https://ui-avatars.com/api/?background=000C32&color=fff&name={{ $comment->name }}" class="rounded-circle"
                                                alt="">
                                        </div>
                                        <div class="w-100 ps-30px last-paragraph-no-margin sm-ps-0">
                                            <a href="#" class="text-dark-gray fw-600">{{ $comment->name }}</a>
                                            <div class="fs-14 lh-24 mb-10px">
                                                {{ $comment->created_at->format('d F Y, H:i') }}</div>
                                            <p class="w-85 sm-w-100">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                    @if ($comment->children->count() > 0)
                                        <ul class="child-comment">
                                            @foreach ($comment->children as $child)
                                                <li>
                                                    <div
                                                        class="d-block d-md-flex w-100 align-items-center align-items-md-start ">
                                                        <div class="w-90px sm-w-65px sm-mb-10px">
                                                            <img src="https://ui-avatars.com/api/?background=000C32&color=fff&name={{ $child->name }}"
                                                                class="rounded-circle" alt="">
                                                        </div>
                                                        <div class="w-100 ps-30px last-paragraph-no-margin sm-ps-0">
                                                            <a href="#" class="text-dark-gray fw-600">{{ $child->name }}</a>
                                                            <div class="fs-14 lh-24 mb-10px">{{ $child->created_at->format('d F Y, H:i') }}</div>
                                                            <p class="w-85 sm-w-100">
                                                                {{ $child->comment }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- end section -->
    <!-- start section -->
    <section id="comments" class="pt-0 overflow-hidden position-relative overlap-height">
        <div class="container overlap-gap-section">
            <div class="row justify-content-center">
                <div class="col-lg-9 mb-3">
                    <h6 class="alt-font text-dark-gray fw-600 ls-minus-05p mb-5px">Tulis Komentar</h6>
                    <div class="mb-5px">Alamat email Anda tidak akan dipublikasikan. Kolom yang diperlukan ditandai *</div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <form action="{{ route('news.comment', $news->slug) }}" method="post" class="row contact-form-style-02">
                        @csrf
                        <div class="col-md-6 mb-30px">
                            <input class="input-name border-radius-4px form-control required" type="text"
                                name="name" placeholder="Nama Kamu*" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6 mb-30px">
                            <input class="border-radius-4px form-control required" type="email" name="email"
                                placeholder="Alamat email Kamu*" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-12 mb-30px">
                            <textarea class="border-radius-4px form-control" cols="40" rows="4" name="comment"
                                placeholder="Pesan Kamu" required>{{ old('comment') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-dark-gray btn-small btn-round-edge" type="submit">Kirim
                                Komentar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
@endsection

@section('scripts')
@endsection
