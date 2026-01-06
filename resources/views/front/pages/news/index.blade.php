@extends('front.app')

@section('seo')
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('news.index') }}">
    <link rel="canonical" href="{{ route('news.index') }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('styles')
     <link rel="stylesheet" href=" {{ asset("front/demos/elearning/elearning.css") }}" />
@endsection

@section('content')
    <!-- Start of breadcrumb section
                                                                                          ============================================= -->
  @include('front.components.breadcrumb')
    <!-- End of breadcrumb section -->

    <section class="pt-0 right-side-bar">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 blog-standard md-mb-50px sm-mb-40px">
                    <!-- start blog item -->
                    @foreach ($list_news as $news)
                        <div class="col-12 mb-40px">
                            <div class="card border-0 no-border-radius box-shadow-extra-large">
                                <div class="blog-image">
                                    <a href="{{ route('news.show', $news->slug) }}"><img src="{{ $news->getThumbnail() }}"
                                            style="width: 100% ;height:400px; object-fit:cover;" alt="" /></a>
                                    <div class="blog-categories">
                                        <a href="{{ route('news.category', $news->category->slug) }}"
                                            class="categories-btn bg-white text-dark-gray text-dark-gray-hover text-uppercase alt-font fw-600">{{ $news->category->name }}</a>
                                    </div>
                                </div>
                                <div class="card-body p-9 bg-white">
                                    <div class="entry-meta mb-20px fs-15">
                                        <span><i class="feather icon-feather-calendar"></i><a
                                                href="#">{{ $news->created_at->diffForHumans() }}</a></span>
                                        <span><i class="feather icon-feather-user"></i><a
                                                href="{{ route('user.profile', $news->user->id) }}">{{ $news->user->name }}</a></span>
                                        <span><i class="feather icon-feather-eye"></i><a
                                                href="#">{{ $news->viewers->count() }} Views</a></span>
                                        <span><i class="feather icon-feather-message-square"></i><a
                                                href="#">{{ $news->comments->count() }} Komentar</a></span>
                                    </div>
                                    <a href="{{ route('news.show', $news->slug) }}"
                                        class="text-dark-gray card-title mb-20px fw-600 fs-24 d-block">{{ $news->title }}</a>
                                    <p class="text-medium-gray mb-20px">{{ Str::limit(strip_tags($news->content), 180) }}
                                    </p>
                                    <a href="{{ route('news.show', $news->slug) }}"
                                        class="btn btn-link btn-large text-base-color fw-600">Baca Selengkapnya<span
                                            class="bg-base-color"></span></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- end blog item -->
                    <div class="col-12 mt-8 d-flex justify-content-center">
                        <ul class="pagination pagination-style-01 fs-13 fw-500 mb-0">
                            @if ($list_news->onFirstPage())
                                <li class="page-item disabled"><a class="page-link" href="#"><i
                                            class="feather icon-feather-arrow-left fs-18 d-xs-none"></i></a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ request()->routeIs('news.category') ? route('news.category', ['slug' => $category->slug, 'page' => $list_news->currentPage() - 1]) : route('news.index', ['page' => $list_news->currentPage() - 1]) }}">
                                        <i class="feather icon-feather-arrow-left fs-18 d-xs-none"></i>
                                    </a>
                                </li>
                            @endif

                            @php
                                // Menghitung halaman pertama dan terakhir yang akan ditampilkan
                                $start = max($list_news->currentPage() - 2, 1);
                                $end = min($start + 4, $list_news->lastPage());
                            @endphp

                            @if ($start > 1)
                                <!-- Menampilkan halaman pertama jika tidak termasuk dalam range -->
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ request()->routeIs('news.category') ? route('news.category', ['slug' => $category->slug, 'page' => 1]) : route('news.index', ['page' => 1]) }}">01</a>
                                </li>
                                @if ($start > 2)
                                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                @endif
                            @endif

                            @foreach ($list_news->getUrlRange($start, $end) as $page => $url)
                                @if ($page == $list_news->currentPage())
                                    <li class="page-item active"><a class="page-link"
                                            href="#">{{ sprintf('%02d', $page) }}</a></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ request()->routeIs('news.category') ? route('news.category', ['slug' => $category->slug, 'page' => $page]) : route('news.index', ['page' => $page]) }}">{{ sprintf('%02d', $page) }}</a>
                                    </li>
                                @endif
                            @endforeach

                            @if ($end < $list_news->lastPage())
                                @if ($end < $list_news->lastPage() - 1)
                                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ request()->routeIs('news.category') ? route('news.category', ['slug' => $category->slug, 'page' => $list_news->lastPage()]) : route('news.index', ['page' => $list_news->lastPage()]) }}">{{ sprintf('%02d', $list_news->lastPage()) }}</a>
                                </li>
                            @endif

                            @if ($list_news->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ request()->routeIs('news.category') ? route('news.category', ['slug' => $category->slug, 'page' => $list_news->currentPage() + 1]) : route('news.index', ['page' => $list_news->currentPage() + 1]) }}">
                                        <i class="feather icon-feather-arrow-right fs-18 d-xs-none"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled"><a class="page-link" href="#"><i
                                            class="feather icon-feather-arrow-right fs-18 d-xs-none"></i></a></li>
                            @endif
                        </ul>
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
                    {{-- <div class="mb-15 md-mb-50px xs-mb-35px elements-social social-icon-style-10">
                        <div
                            class="fw-600 fs-19 lh-22 ls-minus-05px text-dark-gray border-bottom border-color-dark-gray border-2 d-block mb-30px pb-15px position-relative">
                            Stay connected</div>
                        <div class="row row-cols-2 row-cols-lg-2 justify-content-center align-items-center g-0">
                            <div
                                class="col border-bottom border-end border-color-extra-medium-gray ps-25px pe-25px xl-ps-15px xl-pe-15px lg-ps-10px lg-pe-10px pt-10px pb-10px">
                                <a class="facebook text-dark-gray" href="https://www.facebook.com/" target="_blank">
                                    <i class="fa-brands fa-facebook-f fs-18 me-10px"></i>
                                    <span class="fw-500">Facebook</span>
                                </a>
                            </div>
                            <div
                                class="col border-bottom border-color-extra-medium-gray ps-25px pe-25px xl-ps-15px xl-pe-15px lg-ps-10px lg-pe-10px pt-10px pb-10px">
                                <a class="dribbble text-dark-gray" href="http://www.dribbble.com" target="_blank">
                                    <i class="fa-brands fa-dribbble fs-18 me-10px"></i>
                                    <span class="fw-500">Dribbble</span>
                                </a>
                            </div>
                            <div
                                class="col border-bottom border-end border-color-extra-medium-gray ps-25px pe-25px xl-ps-15px xl-pe-15px lg-ps-10px lg-pe-10px pt-10px pb-10px">
                                <a class="twitter text-dark-gray" href="http://www.twitter.com" target="_blank">
                                    <i class="fa-brands fa-twitter fs-18 me-10px"></i>
                                    <span class="fw-500">Twitter</span>
                                </a>
                            </div>
                            <div
                                class="col border-bottom border-color-extra-medium-gray ps-25px pe-25px xl-ps-15px xl-pe-15px lg-ps-10px lg-pe-10px pt-10px pb-10px">
                                <a class="youtube text-dark-gray" href="http://www.youtube.com" target="_blank">
                                    <i class="fa-brands fa-youtube fs-18 me-10px"></i>
                                    <span class="fw-500">Youtube</span>
                                </a>
                            </div>
                            <div
                                class="col border-bottom border-end border-color-extra-medium-gray ps-25px pe-25px xl-ps-15px xl-pe-15px lg-ps-10px lg-pe-10px pt-10px pb-10px">
                                <a class="instagram text-dark-gray" href="http://www.instagram.com" target="_blank">
                                    <i class="fa-brands fa-instagram fs-18 me-10px"></i>
                                    <span class="fw-500">Instagram</span>
                                </a>
                            </div>
                            <div
                                class="col border-bottom border-color-extra-medium-gray ps-25px pe-25px xl-ps-15px xl-pe-15px lg-ps-10px lg-pe-10px pt-10px pb-10px">
                                <a class="vimeo text-dark-gray" href="https://vimeo.com/" target="_blank">
                                    <i class="fa-brands fa-vimeo-v fs-18 me-10px"></i>
                                    <span class="fw-500">Vimeo</span>
                                </a>
                            </div>
                            <div
                                class="col border-end border-color-extra-medium-gray ps-25px pe-25px xl-ps-15px xl-pe-15px lg-ps-10px lg-pe-10px pt-10px pb-10px">
                                <a class="linkedin text-dark-gray" href="https://www.linkedin.com/" target="_blank">
                                    <i class="fa-brands fa-linkedin-in fs-18 me-10px"></i>
                                    <span class="fw-500">Linkedin</span>
                                </a>
                            </div>
                            <div class="col ps-25px pe-25px xl-ps-15px xl-pe-15px lg-ps-10px lg-pe-10px pt-10px pb-10px">
                                <a class="behance text-dark-gray" href="http://www.behance.com/" target="_blank">
                                    <i class="fa-brands fa-behance fs-18 me-10px"></i>
                                    <span class="fw-500 fs-16">Behance</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mb-15 md-mb-50px xs-mb-35px">
                        <div
                            class="fw-600 fs-19 lh-22 ls-minus-05px text-dark-gray border-bottom border-color-dark-gray border-2 d-block mb-30px pb-15px position-relative">
                            Tags cloud</div>
                        <div class="tag-cloud">
                            <a href="blog-grid.html">Development</a>
                            <a href="blog-grid.html">Mountains</a>
                            <a href="blog-grid.html">Lifestyle</a>
                            <a href="blog-grid.html">Hotel</a>
                            <a href="blog-grid.html">Event</a>
                            <a href="blog-grid.html">Multimedia </a>
                            <a href="blog-grid.html">Fashion</a>
                        </div>
                    </div> --}}
                </aside>
                <!-- end sidebar -->
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
