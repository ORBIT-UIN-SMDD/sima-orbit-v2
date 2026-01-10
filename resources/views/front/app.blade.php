<!doctype html>
<html class="no-js" lang="en">


<head>
    @yield('seo')
    <title>{{ $title ?? 'A' }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- google fonts preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- style sheets and font icons -->
    <link rel="stylesheet" href="{{ asset('front/css/vendors.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/icon.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/custom.css') }}" />
    @yield('styles')
</head>

<body data-mobile-nav-style="full-screen-menu" data-mobile-nav-bg-color="#252840">
    <!-- start header -->
    @include('front.layouts.header')
    <!-- end header -->
    @yield('content')
    <!-- start footer -->
    @include('front.layouts.footer')
    <!-- end footer -->
    <!-- start scroll progress -->
    <div class="scroll-progress d-none d-xxl-block">
        <a href="#" class="scroll-top" aria-label="scroll">
            <span class="scroll-text">Scroll</span><span class="scroll-line"><span class="scroll-point"></span></span>
        </a>
    </div>


    <!-- end scroll progress -->
    <!-- javascript libraries -->
    <script type="text/javascript" src="{{ asset('front/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/js/vendors.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/js/main.js') }}"></script>
    @include('sweetalert::alert')
    @yield('scripts')
</body>

</html>
