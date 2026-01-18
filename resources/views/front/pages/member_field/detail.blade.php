@extends('front.app')

@section('seo')
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('memberfield.show', $blog->slug) }}">
    <link rel="canonical" href="{{ route('memberfield.show', $blog->slug) }}">
    <meta property="og:image" content="{{ $blog->getThumbnail() }}">
@endsection

@section('styles')
@endsection

@section('content')
    <!-- start section -->
    <section class="one-fourth-screen bg-dark-gray ipad-top-space-margin sm-mb-50px" data-parallax-background-ratio="0.5"
        style="background-image: url({{ $blog->getThumbnail() }})"></section>
    <!-- end section -->

    <!-- start section -->
    <section class="p-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 overlap-section text-center">
                    <div class="p-10 box-shadow-extra-large border-radius-4px bg-white text-center">
                        <span class="text-uppercase fw-500 fs-13 text-base-color mb-10px d-block">
                            <a href="{{ route('memberfield.division', $blog->memberField->slug) }}" class="text-base-color">{{ $blog->memberField->name }}</a>
                        </span>
                        <h3 class="alt-font text-dark-gray fw-600 ls-minus-1px mb-15px">{{ $blog->title }}</h3>
                        <div class="lg-20px sm-mb-0">
                            <span>By <a href="#" class="text-dark-gray">{{ $blog->user->name }}</a></span> on <a
                                href="#" class="text-dark-gray">{{ $blog->created_at->format('d M Y') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="overlap-section text-center p-0 sm-pt-30px">
        <img class="rounded-circle box-shadow-extra-large w-130px h-130px border border-8 border-color-white"
            src="{{ $blog->user->getPhoto() }}" alt="" style="object-fit: cover;">
    </section>

    <!-- start section -->
    <section class="pb-0 pt-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 dropcap-style-01"
                    data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <p>
                        {!! $blog->content !!}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->

    <!-- start section -->
    <section class="half-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9"
                    data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <div class="row mb-30px">
                        <div class="tag-cloud col-md-9 text-center text-md-start sm-mb-15px">
                            @php
                                $tags = explode(',', $blog->meta_keywords ?? '');
                            @endphp
                            @foreach ($tags ?? [] as $tag)
                                @if(trim($tag))
                                    <a href="#">{{ trim($tag) }}</a>
                                @endif
                            @endforeach
                        </div>
                        <div class="tag-cloud col-md-3 text-uppercase text-center text-md-end">
                            <a class="likes-count fw-500 mx-0" href="#"><i
                                    class="fa-regular fa-eye text-red me-10px"></i><span
                                    class="text-dark-gray text-dark-gray-hover">{{ $blog->viewers->count() }}
                                    Dilihat</span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-6">
                            <div
                                class="d-block d-md-flex w-100 box-shadow-extra-large align-items-center border-radius-4px p-7 sm-p-35px">
                                <div class="w-140px text-center me-50px sm-mx-auto">
                                    <img src="{{ $blog->user->getPhoto() }}" class="rounded-circle w-120px h-120px"
                                        alt="" style="object-fit: cover;">
                                    <a href="#"
                                        class="text-dark-gray fw-500 mt-20px d-inline-block lh-20">{{ $blog->user->name }}</a>
                                    <span
                                        class="fs-15 lh-20 d-block sm-mb-15px">{{ $blog->user->position ?? 'Anggota' }}</span>
                                </div>
                                <div class="w-75 sm-w-100 text-center text-md-start last-paragraph-no-margin">
                                    <p>{{ Str::limit($blog->user->bio ?? 'Anggota UKM ORBIT UIN Bukittinggi', 150) }}</p>
                                    <span class="btn btn-link btn-large text-dark-gray mt-15px">Lihat Profil Penulis</span>
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
                                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('memberfield.show', $blog->slug)) }}"
                                                target="_blank" rel="noopener">
                                                <i class="fa-brands fa-facebook-f"></i><span></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="twitter"
                                                href="https://twitter.com/intent/tweet?url={{ urlencode(route('memberfield.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}"
                                                target="_blank" rel="noopener">
                                                <i class="fa-brands fa-twitter"></i><span></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="whatsapp"
                                                href="https://wa.me/?text={{ urlencode($blog->title . ' ' . route('memberfield.show', $blog->slug)) }}"
                                                target="_blank" rel="noopener">
                                                <i class="fa-brands fa-whatsapp"></i><span></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="linkedin"
                                                href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('memberfield.show', $blog->slug)) }}&title={{ urlencode($blog->title) }}"
                                                target="_blank" rel="noopener">
                                                <i class="fa-brands fa-linkedin-in"></i><span></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="email"
                                                href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode(route('memberfield.show', $blog->slug)) }}"
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

    @if ($related_blogs->count() > 0)
        <section class="bg-very-light-gray">
            <div class="container">
                <div class="row justify-content-center mb-2">
                    <div class="col-12 col-lg-7 text-center">
                        <span class="fs-15 fw-500 text-uppercase d-inline-block">Mungkin Kamu Suka</span>
                        <h4 class="text-dark-gray fw-600">Blog Bidang Terkait</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul
                            class="blog-grid blog-wrapper grid-loading grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large">
                            <li class="grid-sizer"></li>

                            @foreach ($related_blogs as $related)
                                <!-- start blog item -->
                                <li class="grid-item">
                                    <div
                                        class="card border-0 border-radius-4px box-shadow-extra-large box-shadow-extra-large-hover">
                                        <div class="blog-image">
                                            <a href="{{ route('memberfield.show', $related->slug) }}"
                                                class="d-block"><img src="{{ $related->getThumbnail() }}"
                                                    alt="" style="width: 100%; height: 200px; object-fit: cover;" /></a>
                                            <div class="blog-categories">
                                                <a href="{{ route('memberfield.division', $related->memberField->slug) }}"
                                                    class="categories-btn bg-white text-dark-gray text-dark-gray-hover text-uppercase alt-font fw-700">{{ $related->memberField->name }}</a>
                                            </div>
                                        </div>
                                        <div class="card-body p-12">
                                            <a href="{{ route('memberfield.show', $related->slug) }}"
                                                class="card-title mb-15px fw-600 fs-17 lh-26 text-dark-gray text-dark-gray-hover d-inline-block">{{ $related->title }}</a>
                                            <p>{{ Str::limit(strip_tags($related->content), 100) }}</p>
                                            <div
                                                class="author d-flex justify-content-center align-items-center position-relative overflow-hidden fs-14 text-uppercase">
                                                <div class="me-auto">
                                                    <span
                                                        class="blog-date fw-500 d-inline-block">{{ $related->created_at->format('d M Y') }}</span>
                                                    <div class="d-inline-block author-name">By <a
                                                            href="#"
                                                            class="text-dark-gray text-dark-gray-hover text-decoration-line-bottom fw-600">{{ $related->user->name ?? '-' }}</a>
                                                    </div>
                                                </div>
                                                <div class="like-count">
                                                    <a href="{{ route('memberfield.show', $related->slug) }}"><i
                                                            class="fa-regular fa-eye text-red d-inline-block"></i><span
                                                            class="text-dark-gray align-middle fw-600">{{ $related->viewers->count() }}</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- end blog item -->
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </section>
    @endif

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
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </section>

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
                    <form action="{{ route('memberfield.comment', $blog->slug) }}" method="post" class="row contact-form-style-02">
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
