@extends('front.app')

@section('seo')
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('memberfield.index') }}">
    <link rel="canonical" href="{{ route('memberfield.index') }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('styles')
     <link rel="stylesheet" href=" {{ asset("front/demos/elearning/elearning.css") }}" />
@endsection

@section('content')
    @include('front.components.breadcrumb')

    <section class="pt-0 ps-11 pe-11 xl-ps-2 xl-pe-2">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12 col-md-6 col-lg-4 mx-auto">
                    <form method="GET" action="{{ $member_field ? route('memberfield.division', ['slug' => $member_field->slug]) : route('memberfield.index') }}">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Cari blog..." value="{{ request('q') }}">
                            <button type="submit" class="btn btn-dark-gray">
                                <i class="feather icon-feather-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if($list_blog->count() > 0)
                    <ul class="blog-grid blog-wrapper grid-loading grid grid-4col xl-grid-4col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large">
                        <li class="grid-sizer"></li>
                        @foreach ($list_blog as $blog)
                        <li class="grid-item">
                            <div class="card border-0 border-radius-4px box-shadow-extra-large box-shadow-extra-large-hover">
                                <div class="blog-image">
                                    <a href="{{ route('memberfield.show', $blog->slug) }}" class="d-block">
                                        <img src="{{ $blog->getThumbnail() }}" alt="{{ $blog->title }}" style="width: 100%; height: 200px; object-fit: cover;" />
                                    </a>
                                    <div class="blog-categories">
                                        <a href="{{ route('memberfield.division', $blog->memberField->slug) }}"
                                            class="categories-btn bg-white text-dark-gray text-dark-gray-hover text-uppercase alt-font fw-700">{{ $blog->memberField->name }}</a>
                                    </div>
                                </div>
                                <div class="card-body p-12">
                                    <a href="{{ route('memberfield.show', $blog->slug) }}"
                                        class="card-title mb-15px fw-600 fs-17 lh-26 text-dark-gray text-dark-gray-hover d-inline-block">{{ Str::limit($blog->title, 60) }}</a>
                                    <p>{{ Str::limit(strip_tags($blog->content), 80) }}</p>
                                    <div class="author d-flex justify-content-center align-items-center position-relative overflow-hidden fs-14 text-uppercase">
                                        <div class="me-auto">
                                            <span class="blog-date fw-500 d-inline-block">{{ $blog->created_at->format('d M Y') }}</span>
                                            <div class="d-inline-block author-name">By <a href="{{ route('user.profile', $blog->user->id) }}"
                                                    class="text-dark-gray text-dark-gray-hover text-decoration-line-bottom fw-600">{{ $blog->user->name }}</a></div>
                                        </div>
                                        <div class="like-count">
                                            <a href="{{ route('memberfield.show', $blog->slug) }}"><i
                                                    class="fa-regular fa-eye text-red d-inline-block"></i><span
                                                    class="text-dark-gray align-middle fw-600">{{ $blog->viewers->count() }}</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="col-12 text-center py-5">
                        <i class="feather icon-feather-file-text fs-50 text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">Belum ada blog pada bidang ini</h5>
                    </div>
                    @endif
                </div>

                @if($list_blog->hasPages())
                <div class="col-12 mt-4 d-flex justify-content-center">
                    <ul class="pagination pagination-style-01 fs-13 fw-500 mb-0">
                        @if ($list_blog->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="#"><i
                                        class="feather icon-feather-arrow-left fs-18 d-xs-none"></i></a></li>
                        @else
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $member_field ? route('memberfield.division', ['slug' => $member_field->slug, 'page' => $list_blog->currentPage() - 1]) : route('memberfield.index', ['page' => $list_blog->currentPage() - 1]) }}">
                                    <i class="feather icon-feather-arrow-left fs-18 d-xs-none"></i>
                                </a>
                            </li>
                        @endif

                        @php
                            $start = max($list_blog->currentPage() - 2, 1);
                            $end = min($start + 4, $list_blog->lastPage());
                        @endphp

                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $member_field ? route('memberfield.division', ['slug' => $member_field->slug, 'page' => 1]) : route('memberfield.index', ['page' => 1]) }}">01</a>
                            </li>
                            @if ($start > 2)
                                <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                            @endif
                        @endif

                        @foreach ($list_blog->getUrlRange($start, $end) as $page => $url)
                            @if ($page == $list_blog->currentPage())
                                <li class="page-item active"><a class="page-link"
                                        href="#">{{ sprintf('%02d', $page) }}</a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $member_field ? route('memberfield.division', ['slug' => $member_field->slug, 'page' => $page]) : route('memberfield.index', ['page' => $page]) }}">{{ sprintf('%02d', $page) }}</a>
                                </li>
                            @endif
                        @endforeach

                        @if ($end < $list_blog->lastPage())
                            @if ($end < $list_blog->lastPage() - 1)
                                <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $member_field ? route('memberfield.division', ['slug' => $member_field->slug, 'page' => $list_blog->lastPage()]) : route('memberfield.index', ['page' => $list_blog->lastPage()]) }}">{{ sprintf('%02d', $list_blog->lastPage()) }}</a>
                            </li>
                        @endif

                        @if ($list_blog->hasMorePages())
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $member_field ? route('memberfield.division', ['slug' => $member_field->slug, 'page' => $list_blog->currentPage() + 1]) : route('memberfield.index', ['page' => $list_blog->currentPage() + 1]) }}">
                                    <i class="feather icon-feather-arrow-right fs-18 d-xs-none"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled"><a class="page-link" href="#"><i
                                        class="feather icon-feather-arrow-right fs-18 d-xs-none"></i></a></li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
