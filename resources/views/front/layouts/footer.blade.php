<footer class="p-0 footer-light position-relative">
    <div class="container position-relative">
        <div class="row justify-content-center pt-5 sm-pt-40px">
            <!-- start footer column -->
            <div
                class="col-6 col-xl-3 col-lg-12 col-sm-6 last-paragraph-no-margin text-xl-start text-lg-center order-sm-1 lg-mb-50px sm-mb-30px">
                <a href="demo-it-business.html" class="footer-logo mb-15px d-inline-block">
                    <img src="images/demo-it-business-logo-black.png"
                        data-at2x="images/demo-it-business-logo-black@2x.png" alt="">
                </a>
                <p class="lh-28 w-90 xl-w-100 mx-lg-auto mx-xl-0">
                    {{ Str::limit(strip_tags($setting_web->description), 150, '...') }}
                </p>
                <div class="elements-social social-icon-style-02 mt-15px">
                    <ul class="medium-icon dark">
                        @if ($setting_web->facebook)
                            <li><a href="{{ $setting_web->facebook }}" target="_blank"><i
                                        class="fa-brands fa-facebook-f"></i></a></li>
                        @endif
                        @if ($setting_web->twitter)
                            <li><a href="{{ $setting_web->twitter }}" target="_blank"><i
                                        class="fa-brands fa-twitter"></i></a></li>
                        @endif
                        @if ($setting_web->instagram)
                            <li><a href="{{ $setting_web->instagram }}" target="_blank"><i
                                        class="fa-brands fa-instagram"></i></a></li>
                        @endif
                        @if ($setting_web->linkedin)
                            <li><a href="{{ $setting_web->linkedin }}" target="_blank"><i
                                        class="fa-brands fa-linkedin"></i></a></li>
                        @endif
                        @if ($setting_web->youtube)
                            <li><a href="{{ $setting_web->youtube }}" target="_blank"><i
                                        class="fa-brands fa-youtube"></i></a></li>
                        @endif
                        @if ($setting_web->whatsapp)
                            <li><a href="{{ $setting_web->whatsapp }}" target="_blank"><i
                                        class="fa-brands fa-whatsapp"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <!-- end footer column -->
            <!-- start footer column -->
            <div class="col-6 col-xl-3 col-lg-3 col-sm-4 xs-mb-30px order-sm-3 order-lg-2">
                <span class="fw-600 d-block text-dark-gray mb-5px">LINK</span>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="#">Tentang Kami</a>
                        <div
                            class="bg-dark-gray fw-600 text-white lh-22 text-uppercase border-radius-30px ps-10px pe-10px fs-10 ms-10px d-inline-block align-middle">
                            Hot</div>
                    </li>
                    <li><a href="#">Kontak Kami</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="#">UIN Bukittinggi</a></li>
                    <li><a href="#">Sponsorhip</a></li>
                </ul>
            </div>
            <!-- end footer column -->
            <!-- start footer column -->
            <div class="col-6 col-xl-3 col-lg-3 col-md-3 col-sm-4 xs-mb-30px order-sm-5 order-lg-4">
                <span class="fw-600 d-block text-dark-gray mb-5px">Butuh bantuan?</span>
                <span>Hubungi kami langsung?</span>
                <span class="d-block mb-10px"><a class="text-dark-gray fw-600"
                        href="tel:{{ $setting_web->phone }}">{{ $setting_web->phone }}</a></span>
                <span>Butuh dukungan?</span>
                <a href="mailto:{{ $setting_web->email }}" class="text-dark-gray fw-600">{{ $setting_web->email }}</a>
            </div>
            <!-- end footer column -->
            <!-- start footer column -->
            <div class="col-xl-3 col-lg-3 col-sm-6 md-mb-50px sm-mb-30px xs-mb-0 order-sm-2 order-lg-5">
                <span class="fw-600 d-block text-dark-gray mb-5px">Newsletter</span>
                <p class="lh-28 w-95 mb-10px xs-mb-10px">dapatkan update terbaru dari kami dengan berlangganan
                    newsletter kami!
                </p>
                <div class="d-inline-block w-100 newsletter-style-04 position-relative">
                    <form action="email-templates/subscribe-newsletter.php" method="post"
                        class="position-relative w-100">
                        <input
                            class="fs-15 bg-white w-100 border-0 border-bottom border-1 border-color-dark-gray form-control required"
                            type="email" name="email" placeholder="Enter your email address" />
                        <input type="hidden" name="redirect" value="">
                        <button class="btn submit" aria-label="submit"><i
                                class="icon feather icon-feather-mail icon-small"></i></button>
                        <div
                            class="form-results border-radius-0px p-15px fs-16 lh-24 w-100 text-center position-absolute d-none">
                        </div>
                    </form>
                </div>
            </div>
            <!-- end footer column -->
        </div>
        <div class="row justify-content-center align-items-center pt-7">
            <!-- start divider -->
            <div class="col-12">
                <div class="divider-style-03 divider-style-03-01 border-color-extra-medium-gray"></div>
            </div>
            <!-- end divider -->
            <!-- start copyright -->
            <div
                class="col-lg-5 pt-20px pb-20px md-pt-0 order-2 order-lg-1 text-center text-lg-start last-paragraph-no-margin fs-14">
                <p>&copy; {{ date('Y') }} UKM ORBIT UIN Sjech M.Djamil Djambek Bukittinggi </p>
            </div>
            <!-- end copyright -->
            <!-- start footer menu -->
            <div class="col-lg-7 pt-20px pb-20px md-pt-25px md-pb-5px order-1 order-lg-2 text-center text-lg-end fs-14">
                <ul class="footer-navbar sm-lh-normal">
                    <li><a href="#" class="nav-link">Privacy policy</a></li>
                    <li><a href="#" class="nav-link">Terms and conditions</a></li>
                    <li><a href="#" class="nav-link">Sponsorship</a></li>
                </ul>
            </div>
            <!-- end footer menu -->
        </div>
    </div>
</footer>
