@extends('front.app')

@section('seo')
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('home') }}">
    <link rel="canonical" href="{{ route('home') }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('front/css/application.css') }}"> --}}
@endsection

@section('content')
    <!-- start hero section -->
    @include('front.partials.hero')
    <!-- end hero section -->
    <!-- start section -->
    <section class="position-relative overflow-hidden pt-3 sm-pt-50px">
        <div id="particles-02" data-particle="true"
            data-particle-options='{"particles": {"number": {"value": 5,"density": {"enable": true,"value_area": 1000}},"color":{"value":["#b7b9be", "#dd6531"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.5,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"move": {"enable": true,"speed":2,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}'
            class="position-absolute h-100 top-0 left-0 z-index-minus-1"></div>
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-md-2 justify-content-center mb-7"
                data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <!-- start features box item -->
                @foreach ($list_member_field as $member_field)
                    <div class="col icon-with-text-style-01 md-mb-30px mb-3">
                        <div class="feature-box feature-box-left-icon last-paragraph-no-margin">
                            <div class="feature-box-icon me-20px">
                                <img src="{{ $member_field->getImage() }}" alt="" class="w-80px h-80px" />
                            </div>
                            <div class="feature-box-content">
                                <span
                                    class="d-inline-block fs-18 text-dark-gray fw-700 mb-5px">{{ $member_field->name }}</span>
                                <p class="w-80 xl-w-90 lg-w-100">{{ Str::limit($member_field->description, 100) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- end features box item -->
            </div>
            <div class="row mb-10 align-items-center">
                <div class="col-lg-5 position-relative md-mb-20">
                    @if ($about_us[0] ?? false)
                        <div class="w-70 xs-w-80" data-animation-delay="50" data-shadow-animation="true">
                            <img src="{{ $about_us[0]->getImage() }}" alt="" class="border-radius-8px w-100">
                        </div>
                    @endif
                    @if ($about_us[1] ?? false)
                        <div class="w-60 overflow-hidden position-absolute right-minus-15px xs-right-15px xs-w-60 bottom-minus-50px"
                            data-shadow-animation="true" data-animation-delay="250"
                            data-bottom-top="transform: translateY(50px)" data-top-bottom="transform: translateY(-50px)">
                            <img src="{{ $about_us[1]->getImage() }}" alt=""
                                class="border-radius-8px w-100 box-shadow-quadruple-large" />
                        </div>
                    @endif
                </div>
                <div class="col-xl-5 col-lg-6 offset-lg-1"
                    data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span
                        class="ps-25px pe-25px mb-20px text-uppercase text-base-color fs-12 lh-40 fw-700 border-radius-100px bg-gradient-very-light-gray-transparent d-inline-flex"><i
                            class="bi bi-award fs-16 me-5px"></i>Tentang Kami</span>
                    <h3 class="text-dark-gray fs-50 fw-700 ls-minus-2px">{{ $about_us[0]->name }}</h3>
                    <p class="mb-40px sm-mb-25px">{{ Str::limit(strip_tags($about_us[0]->content), 300) }}</p>


                    <a href="demo-it-business-contact.html" class="btn btn-rounded border-1 ls-0px ">
                        <span>
                            <span class="btn-double-text" data-text="Contact us">Lihat Selengkapnya</span>
                            <span><i class="fa-solid fa-arrow-right"></i></span>
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </section>
    <!-- end section -->


    <section class="bg-gradient-solitude-blue-transparent pt-0 ps-10 pe-10 xl-ps-2 xl-pe-2 sm-mx-0 pt-5">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-xl-6 col-lg-8 text-center position-relative page-title-double-large">
                    <div class="d-flex flex-column justify-content-center extra-very-small-screen">
                        <h1 class="text-dark-gray alt-font ls-minus-1px fw-700">Berita & Artikel</h1>
                        <h2 class="text-dark-gray d-inline-block fw-400 ls-0px w-80 xs-w-100 mx-auto">
                            Temukan berbagai informasi terbaru seputar kegiatan, prestasi, dan inovasi dari UKM ORBIT UIN
                            Sjech M.Djamil Djambek Bukittinggi.
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <ul
                        class="blog-masonry blog-wrapper grid-loading grid grid-4col xl-grid-4col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large">
                        <li class="grid-sizer"></li>
                        <!-- start blog item -->


                        @foreach ($list_news as $news)
                            <li class="grid-item">
                                <div
                                    class="card border-0 border-radius-4px overflow-hidden box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                                    <div class="card-top d-flex align-items-center">
                                        <a href="#"><img src="{{ $news->user->getPhoto() }}" class="avtar"
                                                alt=""></a>
                                        <span class="fs-15">By <a href="#"
                                                class="text-dark-gray text-dark-gray-hover fw-600">{{ $news->user->name }}</a></span>
                                        <div class="like-count ms-auto fs-13">
                                            <a href="#"><i class="fa-regular fa-eye text-red d-inline-block"></i><span
                                                    class="text-dark-gray fw-600">{{ $news->viewers->count() }}</span></a>
                                        </div>
                                    </div>
                                    <div class="blog-image position-relative overflow-hidden">
                                        <a href="demo-blogger-blog-single-classic.html"><img
                                                src="{{ $news->getThumbnail() }}" alt="" /></a>
                                        <div class="blog-categories">
                                            <a href="blog-simple.html"
                                                class="categories-btn bg-white text-dark-gray text-dark-gray-hover text-uppercase alt-font fw-600">{{ $news->category->name }}</a>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="post-content ps-13 pe-13 pt-11 pb-11">
                                            <a href="demo-blogger-blog-single-classic.html"
                                                class="card-title mb-10px fw-500 fs-17 lh-26 fw-600 text-dark-gray text-dark-gray-hover d-inline-block">{{ $news->title }}</a>
                                            <p class="mb-10px">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                                            <a href="blog-simple.html"
                                                class="blog-date fs-14 text-medium-gray text-dark-gray-hover"><i
                                                    class="feather icon-feather-calendar text-dark-gray fs-15"></i>{{ $news->created_at->format('d F Y') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        <!-- end blog item -->
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- start section -->
    <section class="bg-dark-gray big-section ">
        <div class="container">
            <div class="row justify-content-center mb-5 sm-mb-30px">
                <div class="col-xl-6 col-lg-8 col-md-10 text-center"
                    data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <h3 class="text-white mb-0 fw-600">Pencapaian dan Pertumbuhan Kami</h3>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 justify-content-center counter-style-01">
                <!-- start counter item -->
                <div class="col feature-box md-mb-50px xs-mb-30px">
                    <div class="feature-box-icon">
                        <i class="ti-crown icon-large text-white mb-20px d-block"></i>
                    </div>
                    <div class="feature-box-content">
                        <h2 class="d-inline-block align-middle counter-number fw-700 text-white mb-0 counter"
                            data-speed="2000" data-to="{{ $count_member_field }}"></h2>
                        <span class="d-block text-white fw-500">Bidang</span>
                    </div>
                </div>
                <!-- end counter item -->
                <!-- start counter item -->
                <div class="col feature-box md-mb-50px xs-mb-30px">
                    <div class="feature-box-icon">
                        <i class="ti-user icon-large text-white mb-20px d-block"></i>
                    </div>
                    <div class="feature-box-content">
                        <h2 class="d-inline-block align-middle counter-number fw-700 text-white mb-0 counter"
                            data-speed="2000" data-to="{{ $count_user_member_active }}"></h2>
                        <span class="d-block text-white fw-500">Anggota Aktif</span>
                    </div>
                </div>
                <!-- end counter item -->
                <!-- start counter item -->
                <div class="col feature-box xs-mb-30px">
                    <div class="feature-box-icon">
                        <i class="ti-rocket icon-large text-white mb-20px d-block"></i>
                    </div>
                    <div class="feature-box-content">
                        <h2 class="d-inline-block align-middle counter-number fw-700 text-white mb-0 counter"
                            data-speed="2000" data-to="{{ $count_user_member_admin }}"></h2>
                        <span class="d-block text-white fw-500">Pengurus</span>
                    </div>
                </div>
                <!-- end counter item -->
                <!-- start counter item -->
                <div class="col feature-box">
                    <div class="feature-box-icon">
                        <i class="ti-id-badge icon-large text-white mb-20px d-block"></i>
                    </div>
                    <div class="feature-box-content last-paragraph-no-margin">
                        <h2 class="d-inline-block align-middle counter-number fw-700 text-white mb-0 counter"
                            data-speed="2000" data-to="{{ $count_user_member_alumnus }}"></h2>
                        <span class="d-block text-white fw-500">Alumni</span>
                    </div>
                </div>
                <!-- end counter item -->
            </div>
        </div>
    </section>
    <!-- end section -->

    <!-- start section -->
    <section class="p-0 bg-midnight-blue">
        <div class="container">
            <div class="row align-items-center justify-content-center g-0"
                data-anime='{  "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col-auto d-flex align-items-center py-4">
                    {{-- <img src="https://placehold.co/130x98" alt=""> --}}
                    <div class="fs-17 lh-26 last-paragraph-no-margin text-white pt-15px pb-15px fw-500">
                        <p>Ingin Menjadi Bagian dari UKM ORBIT UIN Sjech M.Djamil Djambek Bukittinggi <a href="#"
                                class="text-decoration-line-bottom text-white">Daftar Disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->

    <!-- start section -->
    <section class="bg-very-light-gray position-relative overflow-hidden">
        <div class="position-absolute right-minus-50px top-50px d-none d-lg-inline-block"
            data-bottom-top="transform: translateY(-50px)" data-top-bottom="transform: translateY(50px)">
            <img src="https://craftohtml.themezaa.com/images/demo-spa-salon-bg-img-02.png" alt="">
        </div>
        <div class="position-absolute left-minus-100px top-50 d-none d-lg-inline-block"
            data-bottom-top="transform: translateY(-50px)" data-top-bottom="transform: translateY(50px)">
            <img src="https://craftohtml.themezaa.com/images/demo-spa-salon-bg-img-03.png" alt=""
                data-no-retina="">
        </div>
        <div class="container">
            <div class="row align-items-center mb-5 sm-mb-30px text-center text-lg-start"
                data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col-lg-5 md-mb-30px">
                    <h3 class="text-dark-gray fw-700 ls-minus-2px mb-0">Kegiatan Mentoring bidang</h3>
                </div>
                <div class="col-lg-4 offset-xl-1 last-paragraph-no-margin md-mb-30px">
                    <p>
                        Kami menyediakan program mentoring yang dirancang khusus untuk membantu anggota kami
                        mengembangkan keterampilan dan pengetahuan di berbagai bidang yang diminati.
                    </p>
                </div>
                <div class="col-xl-2 col-lg-3 d-flex justify-content-center">
                    <!-- start slider navigation -->
                    <div
                        class="slider-one-slide-prev-1 icon-small text-dark-gray swiper-button-prev slider-navigation-style-04 bg-white box-shadow-large">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div
                        class="slider-one-slide-next-1 icon-small text-dark-gray swiper-button-next slider-navigation-style-04 bg-white box-shadow-large">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                    <!-- end slider navigation -->
                </div>
            </div>
            <div class="row align-items-center"
                data-anime='{ "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col-12">
                    <div class="outside-box-right-20 sm-outside-box-right-0">
                        <div class="swiper magic-cursor slider-one-slide"
                            data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loop": true, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 4 }, "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 2 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>
                            <div class="swiper-wrapper">
                                <!-- start slider item -->
                                <div class="swiper-slide">
                                    <!-- start services box style -->
                                    <div
                                        class="services-box-style-03 last-paragraph-no-margin border-radius-6px overflow-hidden">
                                        <div class="position-relative">
                                            <a href="demo-it-business-services-details.html"><img
                                                    src="https://placehold.co/600x440" alt=""></a>
                                            <a href="#"
                                                class="btn btn-very-small btn-rounded btn-dark-gray text-white btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16 position-absolute right-30px top-30px text-uppercase">analytics</a>
                                        </div>
                                        <div class="bg-white">
                                            <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">Data and
                                                    analytics</a>
                                                <p>Lorem ipsum simply dummy text of amet consectetur.</p>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                    <span>
                                                        <span class="btn-text">Explore services</span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end services box style -->
                                </div>
                                <!-- end slider item -->
                                <!-- start slider item -->
                                <div class="swiper-slide">
                                    <!-- start services box style -->
                                    <div
                                        class="services-box-style-03 last-paragraph-no-margin border-radius-6px overflow-hidden">
                                        <div class="position-relative">
                                            <a href="demo-it-business-services-details.html"><img
                                                    src="https://placehold.co/600x440" alt=""></a>
                                            <a href="#"
                                                class="btn btn-very-small btn-rounded btn-dark-gray text-white btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16 position-absolute right-30px top-30px text-uppercase">Finance</a>
                                        </div>
                                        <div class="bg-white">
                                            <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">Finance
                                                    consulting</a>
                                                <p>Lorem ipsum simply dummy text of amet consectetur.</p>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                    <span>
                                                        <span class="btn-text">Explore services</span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end services box style -->
                                </div>
                                <!-- end slider item -->
                                <!-- start slider item -->
                                <div class="swiper-slide">
                                    <!-- start services box style -->
                                    <div
                                        class="services-box-style-03 last-paragraph-no-margin border-radius-6px overflow-hidden">
                                        <div class="position-relative">
                                            <a href="demo-it-business-services-details.html"><img
                                                    src="https://placehold.co/600x440" alt=""></a>
                                            <a href="#"
                                                class="btn btn-very-small btn-rounded btn-dark-gray text-white btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16 position-absolute right-30px top-30px text-uppercase">analytics</a>
                                        </div>
                                        <div class="bg-white">
                                            <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">Tech
                                                    innovation</a>
                                                <p>Lorem ipsum simply dummy text of amet consectetur.</p>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                    <span>
                                                        <span class="btn-text">Explore services</span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end services box style -->
                                </div>
                                <!-- end slider item -->
                                <!-- start slider item -->
                                <div class="swiper-slide">
                                    <!-- start services box style -->
                                    <div
                                        class="services-box-style-03 last-paragraph-no-margin border-radius-6px overflow-hidden">
                                        <div class="position-relative">
                                            <a href="demo-it-business-services-details.html"><img
                                                    src="https://placehold.co/600x440" alt=""></a>
                                            <a href="#"
                                                class="btn btn-very-small btn-rounded btn-dark-gray text-white btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16 position-absolute right-30px top-30px text-uppercase">Digital</a>
                                        </div>
                                        <div class="bg-white">
                                            <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">Digital
                                                    commerce</a>
                                                <p>Lorem ipsum simply dummy text of amet consectetur.</p>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                    <span>
                                                        <span class="btn-text">Explore services</span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end services box style -->
                                </div>
                                <!-- end slider item -->
                                <!-- start slider item -->
                                <div class="swiper-slide">
                                    <!-- start services box style -->
                                    <div
                                        class="services-box-style-03 last-paragraph-no-margin border-radius-4px overflow-hidden">
                                        <div class="position-relative">
                                            <a href="demo-it-business-services-details.html"><img
                                                    src="https://placehold.co/600x440" alt=""></a>
                                            <a href="#"
                                                class="btn btn-very-small btn-rounded btn-dark-gray text-white btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16 position-absolute right-30px top-30px text-uppercase">Digital</a>
                                        </div>
                                        <div class="bg-white">
                                            <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">Cloud
                                                    computing</a>
                                                <p>Lorem ipsum simply dummy text of amet consectetur.</p>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                    <span>
                                                        <span class="btn-text">Explore services</span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end services box style -->
                                </div>
                                <!-- end slider item -->
                                <!-- start slider item -->
                                <div class="swiper-slide">
                                    <!-- start services box style -->
                                    <div
                                        class="services-box-style-03 last-paragraph-no-margin border-radius-6px overflow-hidden">
                                        <div class="position-relative">
                                            <a href="demo-it-business-services-details.html"><img
                                                    src="https://placehold.co/600x440" alt=""></a>
                                            <a href="#"
                                                class="btn btn-very-small btn-rounded btn-dark-gray text-white btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16 position-absolute right-30px top-30px text-uppercase">analytics</a>
                                        </div>
                                        <div class="bg-white">
                                            <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">Data and
                                                    analytics</a>
                                                <p>Lorem ipsum simply dummy text of amet consectetur.</p>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                    <span>
                                                        <span class="btn-text">Explore services</span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end services box style -->
                                </div>
                                <!-- end slider item -->
                                <!-- start slider item -->
                                <div class="swiper-slide">
                                    <!-- start services box style -->
                                    <div
                                        class="services-box-style-03 last-paragraph-no-margin border-radius-6px overflow-hidden">
                                        <div class="position-relative">
                                            <a href="demo-it-business-services-details.html"><img
                                                    src="https://placehold.co/600x440" alt=""></a>
                                            <a href="#"
                                                class="btn btn-very-small btn-rounded btn-dark-gray text-white btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16 position-absolute right-30px top-30px text-uppercase">Finance</a>
                                        </div>
                                        <div class="bg-white">
                                            <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">Finance
                                                    consulting</a>
                                                <p>Lorem ipsum simply dummy text of amet consectetur.</p>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                    <span>
                                                        <span class="btn-text">Explore services</span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end services box style -->
                                </div>
                                <!-- end slider item -->
                                <!-- start slider item -->
                                <div class="swiper-slide">
                                    <!-- start services box style -->
                                    <div
                                        class="services-box-style-03 last-paragraph-no-margin border-radius-6px overflow-hidden">
                                        <div class="position-relative">
                                            <a href="demo-it-business-services-details.html"><img
                                                    src="https://placehold.co/600x440" alt=""></a>
                                            <a href="#"
                                                class="btn btn-very-small btn-rounded btn-dark-gray text-white btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16 position-absolute right-30px top-30px text-uppercase">analytics</a>
                                        </div>
                                        <div class="bg-white">
                                            <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">Tech
                                                    innovation</a>
                                                <p>Lorem ipsum simply dummy text of amet consectetur.</p>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                <a href="demo-it-business-services-details.html"
                                                    class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                    <span>
                                                        <span class="btn-text">Explore services</span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="fa-solid fa-arrow-right"></i></span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end services box style -->
                                </div>
                                <!-- end slider item -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->

    <section class="bg-white">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-xl-6 col-lg-7 col-md-8 text-center"
                    data-anime='{ "opacity": [0,1], "duration": 800, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="fw-600 ls-1px fs-16 alt-font d-inline-block text-uppercase mb-5px text-base-color">Konten
                        Instagram</span>
                    <h2 class="alt-font text-dark-gray fw-600 ls-minus-2px">Instagram Feed</h2>
                </div>
            </div>
            <div class="tagembed-widget" style="width:100%;height:100%;overflow:auto;" data-widget-id="312588"
                data-website="1"></div>
            <script src="https://widget.tagembed.com/embed.min.js" type="text/javascript"></script>

        </div>
    </section>

    <!-- start section -->
    @include('front.partials.sima-orbit-banner')
    <!-- end section -->
    <!-- start subscription popup -->
    {{-- <div id="subscribe-popup" class="mfp-hide subscribe-popup">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 p-60px pt-40px pb-40px xs-p-30px xs-pt-30px xs-pb-30px position-relative box-shadow-quadruple-large bg-white border-radius-10px">
                        <div class="row">
                            <div class="col-12 text-center mb-20px">
                                <img src="https://placehold.co/160x160" alt=""/>
                            </div>
                            <div class="col-12 newsletter-popup position-relative">
                                <h5 class="d-inline-block fw-500 text-dark-gray ls-minus-1px mb-20px">Grow your business with <span class="fw-700">crafto agency.</span></h5>
                                <div class="col icon-with-text-style-08 mb-5px" style="">
                                    <div class="feature-box feature-box-left-icon-middle d-inline-flex align-middle">
                                        <div class="feature-box-icon me-15px">
                                            <i class="bi bi-wallet2 icon-small text-base-color"></i>
                                        </div>
                                        <div class="feature-box-content">
                                            <span class="text-dark-gray">Increase your conversion rate.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col icon-with-text-style-08 mb-5px" style="">
                                    <div class="feature-box feature-box-left-icon-middle d-inline-flex align-middle">
                                        <div class="feature-box-icon me-15px">
                                            <i class="bi bi-calendar-check icon-small text-base-color"></i>
                                        </div>
                                        <div class="feature-box-content">
                                            <span class="text-dark-gray">Save your time and effort spent.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col icon-with-text-style-08 md-mb-15px" style="">
                                    <div class="feature-box feature-box-left-icon-middle d-inline-flex align-middle">
                                        <div class="feature-box-icon me-15px">
                                            <i class="bi bi-clock icon-small text-base-color"></i>
                                        </div>
                                        <div class="feature-box-content">
                                            <span class="text-dark-gray">Make your business stand out.</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="demo-it-business-contact.html" class="btn btn-extra-large btn-gradient-purple-pink btn-rounded btn-box-shadow d-block mt-30px">Let's talk now <i class="fa-solid fa-arrow-right"></i></a>
                                <a href="#" class="btn btn-link hover-text-light btn-large text-dark-gray d-block mt-15px">No thanks</a>
                            </div>
                            <button title="Close (Esc)" type="button" class="mfp-close text-dark-gray"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    <!-- end subscription popup -->
@endsection

@section('scripts')
@endsection
