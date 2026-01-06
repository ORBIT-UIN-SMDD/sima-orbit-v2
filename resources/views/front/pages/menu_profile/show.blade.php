@extends('front.app')

@section('seo')
<title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('profil.show', $profil->slug) }}">
    <link rel="canonical" href="{{ route('profil.show', $profil->slug) }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('styles')
@endsection

@section('content')
    @include('front.components.breadcrumb')

    <section class="pb-0">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 blog-standard md-mb-50px sm-mb-40px">

                    <div class="col-12 mb-40px">
                        <div class="row justify-content-center">
                            <div class="col-lg-12S">
                                <h4 class="alt-font text-dark-gray fw-600 ls-minus-1px w-90 md-w-100">{{ $profil->name }}
                                </h4>
                            </div>

                            <p>
                                {!! $profil->content !!}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- start sidebar -->
                <aside class="col-12 col-xl-4 col-lg-4 col-md-7 ps-55px xl-ps-50px lg-ps-15px sidebar">
                    <div class="mb-15 md-mb-50px xs-mb-35px">
                        <div
                            class="fw-600 fs-19 lh-22 ls-minus-05px text-dark-gray border-bottom border-color-dark-gray border-2 d-block mb-20px pb-10px position-relative">
                            Tentang {{ $setting_web->name }}
                        </div>

                        <p>
                            {{ strip_tags($setting_web->about) }}
                        </p>
                    </div>
                     @include('front.components.profil_list')
                    @include('front.components.news-categories')
                    @include('front.components.latest-news')

                </aside>
                <!-- end sidebar -->
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
