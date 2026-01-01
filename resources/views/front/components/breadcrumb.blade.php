  <section class="ipad-top-space-margin md-pt-0 mb-3" style="background-color: #f7f9fa; padding-bottom: 40px; padding-top: 130px;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-xl-8 col-lg-8 text-center position-relative page-title-double-large">
                    <div class="d-flex flex-column justify-content-center ">
                        <h1 class="text-dark-gray alt-font ls-minus-1px fw-700 my-20px">
                            {{ $page_heading ?? '-' }}
                        </h1>
                    </div>
                    <div class="mt-auto justify-content-center breadcrumb breadcrumb-style-01 fs-14 text-dark-gray">

                        <ul>
                            @isset($breadcrumbs)
                                @foreach ($breadcrumbs as $breadcrumb)
                                    <li><a href="{{ $breadcrumb['link'] }}"
                                            class="text-dark-gray text-dark-gray-hover">{{ $breadcrumb['name'] }}</a></li>
                                @endforeach
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>F
