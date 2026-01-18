@extends('front.app')

@section('seo')
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('about') }}">
    <link rel="canonical" href="{{ route('about') }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('styles')
    <link rel="stylesheet" href=" {{ asset('front/demos/elearning/elearning.css') }}" />
@endsection

@section('content')
    <!-- Start of breadcrumb section
                                                                                                          ============================================= -->
    @include('front.components.breadcrumb')
    <!-- End of breadcrumb section -->

    <!-- start section -->

    <section id="down-section" class="background-position-center-top sm-background-image-none"
        style="background-image: url('{{ asset('front/images/vertical-line-bg.svg') }}')">
        <div class="container">
            <div class="row align-items-center justify-content-center mb-8 xs-mb-50px">
                <div class="col-lg-6 col-md-10 position-relative md-mb-50px sm-mb-30px"
                    data-anime='{ "effect": "slide", "direction": "tb", "color": "#252840", "duration": 1000, "delay": 0 }'>
                    <img class="w-100 border-radius-5px" src="{{ $about_first->getImage() }}" alt="">
                </div>
                <div class="col-xl-4 offset-lg-1 col-lg-5 col-md-10 text-center text-lg-start"
                    data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="alt-font text-uppercase fw-600 mb-15px d-inline-block ls-1px">Tentang Kami</span>
                    <h3 class="alt-font fw-600 text-dark-gray ls-minus-1px shadow-none" data-shadow-animation="true"
                        data-animation-delay="1500">{{ $about_first->name }}</h3>
                    <p class="mb-35px sm-mb-25px">
                        {!! $about_first->content !!}
                    </p>

                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 justify-content-center text-center"
                data-anime='{"el": "childs", "opacity": [0,1], "translateX": [50, 0], "duration": 800, "delay":300, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col last-paragraph-no-margin sm-mb-40px">
                    <h2 class="alt-font fw-900 text-dark-gray m-0">{{ $count_member_field }}</h2>
                    <p>Bidang</p>
                </div>
                <div class="col last-paragraph-no-margin sm-mb-40px">
                    <h2 class="alt-font fw-900 text-dark-gray m-0">{{ $count_user_member_active }}</h2>
                    <p>Anggota Aktif</p>
                </div>
                <div class="col last-paragraph-no-margin xs-mb-40px">
                    <h2 class="alt-font fw-900 text-dark-gray m-0">{{ $count_user_member_admin }}</h2>
                    <p>Pengurus</p>
                </div>
                <div class="col last-paragraph-no-margin">
                    <h2 class="alt-font fw-900 text-dark-gray m-0">{{ $count_user_member_alumnus }}</h2>
                    <p>Alumni</p>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->


    @if ($about_other->count() > 0)

    <section class="background-position-center-top sm-background-image-none"
        style="background-image: url('{{ asset('front/images/vertical-line-bg.svg') }}')">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-10 text-center text-lg-start"
                    data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="swiper slider-one-slide md-mb-50px sm-mb-40px text-slider-style-01"
                        data-slider-options='{ "slidesPerView": 1, "loop": true, "pagination": { "el": ".slider-one-slide-pagination", "clickable": true }, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "slide" }'>
                        <div class="swiper-wrapper mb-30px">
                            <!-- start text slider item -->
                            @foreach ($about_other as $about)
                                <div class="swiper-slide">

                                    <h3 class="alt-font text-dark-gray mb-30px md-mb-25px fw-600 ls-minus-1px">
                                        {{ $about->name }}
                                    </h3>
                                    <span class="d-inline-block w-95 md-w-100">
                                        {!! $about->content !!}
                                    </span>
                                </div>
                            @endforeach
                            <!-- end text slider item -->
                        </div>
                        <div class="d-flex justify-content-center justify-content-lg-start">
                            <!-- start slider navigation -->
                            <div
                                class="slider-one-slide-prev-1 text-dark-gray swiper-button-prev slider-navigation-style-04 border border-1 border-color-extra-medium-gray bg-white">
                                <i class="fa-solid fa-arrow-left"></i>
                            </div>
                            <div
                                class="slider-one-slide-next-1 text-dark-gray swiper-button-next slider-navigation-style-04 border border-1 border-color-extra-medium-gray bg-white">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                            <!-- end slider navigation -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 offset-xl-1 position-relative text-end md-mb-6 sm-mb-10 xs-mb-12">
                    <div class="text-end w-80 md-w-75 ms-auto" data-animation-delay="100" data-shadow-animation="true"
                        data-bottom-top="transform: translateY(50px)" data-top-bottom="transform: translateY(-50px)">
                        <img src="{{ $about_other[0]->getImage() ?? '' }}" alt="" class="border-radius-5px">
                    </div>
                    @if ($about_other->count() > 1)
                    <div class="w-60 md-w-50 xs-w-55 overflow-hidden position-absolute left-15px bottom-minus-50px"
                        data-shadow-animation="true" data-animation-delay="200"
                        data-bottom-top="transform: translateY(-50px)" data-top-bottom="transform: translateY(50px)">
                        <img src="{{ $about_other[1]->getImage() ?? '' }}" alt="" class="border-radius-5px" />
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    @include('front.partials.sima-orbit-banner')

    <!-- start section -->
    {{-- <section class="background-position-center-top pt-0 sm-background-image-none" style="background-image: url('images/vertical-line-bg.svg')">
            <div class="container">
                <div class="row justify-content-center mb-3">
                    <div class="col-lg-7 text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <span class="alt-font text-uppercase fw-600 d-inline-block ls-1px">Core people</span>
                        <h3 class="alt-font text-dark-gray fw-600 ls-minus-1px shadow-none" data-shadow-animation="true" data-animation-delay="1000">Expert <span class="text-highlight fw-800">consultant<span class="bg-gradient-emerald-blue-emerald-green h-8px bottom-10px opacity-6 separator-animation"></span></span></h3>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center" data-anime='{ "el": "childs", "translateY": [15, 0], "translateX": [-15, 0], "opacity": [0,1], "duration": 800, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <!-- start team member item -->
                    <div class="col text-center team-style-01 md-mb-30px">
                        <figure class="mb-0 hover-box box-hover light-hover position-relative">
                            <img src="https://via.placeholder.com/600x759" alt="" />
                            <figcaption class="w-100 p-30px bg-white box-shadow-quadruple-large">
                                <div class="position-relative z-index-1 overflow-hidden">
                                    <span class="d-block alt-font fw-700 text-dark-gray lh-26 fs-18">Jeremy dupont</span>
                                    <span class="text-light-opacity text-uppercase fs-15">Founder</span>
                                    <div class="social-icon hover-text mt-20px lg-mt-10px">
                                        <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f icon-small"></i></a>
                                        <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram icon-small"></i></a>
                                        <a href="https://www.twitter.com/" target="_blank"><i class="fa-brands fa-twitter icon-small"></i></a>
                                        <a href="http://www.dribbble.com" target="_blank"><i class="fa-brands fa-dribbble icon-small"></i></a>
                                    </div>
                                </div>
                                <div class="box-overlay bg-white"></div>
                            </figcaption>
                        </figure>
                    </div>
                    <!-- end team member item -->
                    <!-- start team member item -->
                    <div class="col text-center team-style-01 md-mb-30px">
                        <figure class="mb-0 hover-box box-hover light-hover position-relative">
                            <img src="https://via.placeholder.com/600x759" alt="" />
                            <figcaption class="w-100 p-30px bg-white box-shadow-quadruple-large">
                                <div class="position-relative z-index-1 overflow-hidden">
                                    <span class="d-block alt-font fw-700 text-dark-gray lh-26 fs-18">Jessica dover</span>
                                    <span class="text-light-opacity text-uppercase fs-15">Officer</span>
                                    <div class="social-icon hover-text mt-20px lg-mt-10px">
                                        <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f icon-small"></i></a>
                                        <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram icon-small"></i></a>
                                        <a href="https://www.twitter.com/" target="_blank"><i class="fa-brands fa-twitter icon-small"></i></a>
                                        <a href="http://www.dribbble.com" target="_blank"><i class="fa-brands fa-dribbble icon-small"></i></a>
                                    </div>
                                </div>
                                <div class="box-overlay bg-white"></div>
                            </figcaption>
                        </figure>
                    </div>
                    <!-- end team member item -->
                    <!-- start team member item -->
                    <div class="col text-center team-style-01 xs-mb-30px">
                        <figure class="mb-0 hover-box box-hover light-hover position-relative">
                            <img src="https://via.placeholder.com/600x759" alt="" />
                            <figcaption class="w-100 p-30px bg-white box-shadow-quadruple-large">
                                <div class="position-relative z-index-1 overflow-hidden">
                                    <span class="d-block alt-font fw-700 text-dark-gray lh-26 fs-18">Herman miller</span>
                                    <span class="text-light-opacity text-uppercase fs-15">Advisor</span>
                                    <div class="social-icon hover-text mt-20px lg-mt-10px">
                                        <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f icon-small"></i></a>
                                        <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram icon-small"></i></a>
                                        <a href="https://www.twitter.com/" target="_blank"><i class="fa-brands fa-twitter icon-small"></i></a>
                                        <a href="http://www.dribbble.com" target="_blank"><i class="fa-brands fa-dribbble icon-small"></i></a>
                                    </div>
                                </div>
                                <div class="box-overlay bg-white"></div>
                            </figcaption>
                        </figure>
                    </div>
                    <!-- end team member item -->
                    <!-- start team member item -->
                    <div class="col text-center team-style-01">
                        <figure class="mb-0 hover-box box-hover light-hover position-relative">
                            <img src="https://via.placeholder.com/600x759" alt="" />
                            <figcaption class="w-100 p-30px bg-white box-shadow-quadruple-large">
                                <div class="position-relative z-index-1 overflow-hidden">
                                    <span class="d-block alt-font fw-700 text-dark-gray lh-26 fs-18">John parker</span>
                                    <span class="text-light-opacity text-uppercase fs-15">Consultant</span>
                                    <div class="social-icon hover-text mt-20px lg-mt-10px">
                                        <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f icon-small"></i></a>
                                        <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram icon-small"></i></a>
                                        <a href="https://www.twitter.com/" target="_blank"><i class="fa-brands fa-twitter icon-small"></i></a>
                                        <a href="http://www.dribbble.com" target="_blank"><i class="fa-brands fa-dribbble icon-small"></i></a>
                                    </div>
                                </div>
                                <div class="box-overlay bg-white"></div>
                            </figcaption>
                        </figure>
                    </div>
                    <!-- end team member item -->
                </div>
            </div>
        </section> --}}
    <!-- end section -->

@endsection

@section('scripts')
@endsection
