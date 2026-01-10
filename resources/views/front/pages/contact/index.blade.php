@extends('front.app')

@section('seo')
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('contact') }}">
    <link rel="canonical" href="{{ route('contact') }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('styles')
    <link rel="stylesheet" href=" {{ asset('front/demos/elearning/elearning.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #leaflet-map {
            height: 450px;
            width: 100%;
            border-radius: 6px;
        }
    </style>
@endsection

@section('content')
    <!-- Start of breadcrumb section
                                                                                                                      ============================================= -->
    @include('front.components.breadcrumb')
    <!-- End of breadcrumb section -->


    <!-- start section -->
    <section class="pt-0 half-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div id="leaflet-map"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->

    <!-- start section -->
    <section class="bg-very-light-gray position-relative">
        <div class="container">
            <div class="row mb-8">
                <div class="col-xl-5 col-lg-6 md-mb-50px"
                    data-anime='{ "el": "childs", "translateX": [-50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <div class="bg-white border-radius-6px box-shadow-quadruple-large p-10 ps-12 pe-12 lg-ps-8 lg-pe-8 h-100 d-flex flex-wrap flex-column justify-content-center"
                        data-anime='{ "el": "childs", "translateY": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                        <span
                            class="ps-25px pe-25px mb-20px text-uppercase text-base-color fs-12 lh-40 fw-700 border-radius-100px bg-gradient-very-light-gray-transparent d-inline-flex align-self-start"><i
                                class="bi bi-chat-square-dots fs-16 me-5px"></i>How can help you?</span>
                        <h4 class="text-dark-gray ls-minus-1px fw-700 mb-15px">Kami Siap Membantu!</h4>
                        <p class="w-85 sm-w-100">
                            Kami siap membantu Anda dengan berbagai cara. Apakah Anda memiliki pertanyaan tentang kami,
                        </p>
                        <div class="row row-cols-1 row-cols-sm-2">
                            <div class="col last-paragraph-no-margin mb-25px">
                                <p>Hubungi kami langsung?</p>
                                <a href="tel:{{ $setting_web->phone }}"
                                    class="text-dark-gray fw-600">{{ $setting_web->phone }}</a>
                            </div>
                            <div class="col last-paragraph-no-margin mb-25px">
                                <p>Butuh dukungan langsung?</p>
                                <a href="mailto:{{ $setting_web->email }}"
                                    class="text-dark-gray fw-600">{{ $setting_web->email }}</a>
                            </div>
                            <div class="col last-paragraph-no-margin sm-mb-25px">
                                <p>Bergabung dengan kami?</p>
                                <a href="#" class="text-dark-gray fw-600">Register</a>
                            </div>
                            <div class="col last-paragraph-no-margin">
                                <p>Kunjungi Sekretariat kami?</p>
                                <a href="https://maps.google.com/maps?ll=-37.805688,144.962312&amp;z=17&amp;t=m&amp;hl=en-US&amp;gl=IN&amp;mapclient=embed&amp;cid=13153204942596594449"
                                    target="_blank" class="text-dark-gray fw-600">Lihat di peta google</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-xl-1 md-mb-50px sm-mb-0"
                    data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <h3 class="text-dark-gray ls-minus-2px fw-700">Berikan Pesan Anda</h3>
                    <form id="contact-form" class="contact-form-style-03">
                        @csrf
                        <label for="inputName"
                            class="form-label fs-13 text-uppercase text-dark-gray fw-700 mb-0">Masukkan nama Anda*</label>
                        <div class="position-relative form-group mb-20px">
                            <span class="form-icon"><i class="bi bi-emoji-smile text-dark-gray"></i></span>
                            <input
                                class="fs-15 ps-0 border-radius-0px border-color-dark-gray bg-transparent form-control required"
                                id="inputName" type="text" name="name" placeholder="Siapa nama Anda?" />
                        </div>
                        <label for="inputEmail"
                            class="form-label fs-13 text-uppercase text-dark-gray fw-700 mb-0">Alamat email*</label>
                        <div class="position-relative form-group mb-20px">
                            <span class="form-icon"><i class="bi bi-envelope text-dark-gray"></i></span>
                            <input
                                class="fs-15 ps-0 border-radius-0px border-color-dark-gray bg-transparent form-control required"
                                id="inputEmail" type="email" name="email"
                                placeholder="Masukkan alamat email Anda" />
                        </div>
                        <label for="inputPhone"
                            class="form-label fs-13 text-uppercase text-dark-gray fw-700 mb-0">Telepon/Whatsapp*</label>
                        <div class="position-relative form-group mb-20px">
                            <span class="form-icon"><i class="bi bi-telephone text-dark-gray"></i></span>
                            <input
                                class="fs-15 ps-0 border-radius-0px border-color-dark-gray bg-transparent form-control required"
                                id="inputPhone" type="tel" name="phone"
                                placeholder="Masukkan nomor telepon Anda" />
                        </div>
                        <label for="inputSubject"
                            class="form-label fs-13 text-uppercase text-dark-gray fw-700 mb-0">Subjek*</label>
                        <div class="position-relative form-group mb-20px">
                            <span class="form-icon"><i class="bi bi-bookmark text-dark-gray"></i></span>
                            <input
                                class="fs-15 ps-0 border-radius-0px border-color-dark-gray bg-transparent form-control required"
                                id="inputSubject" type="text" name="subject" placeholder="Masukkan subjek Anda" />
                        </div>
                        <label for="inputMessage"
                            class="form-label fs-13 text-uppercase text-dark-gray fw-700 mb-0">Pesan Anda</label>
                        <div class="position-relative form-group form-textarea mb-0">
                            <textarea class="fs-15 ps-0 border-radius-0px border-color-dark-gray bg-transparent form-control"
                                id="inputMessage" name="message"
                                placeholder="Jelaskan tentang pesan Anda" rows="3"></textarea>
                            <span class="form-icon"><i class="bi bi-chat-square-dots text-dark-gray"></i></span>
                        </div>
                        <div class="row mt-25px align-items-center">
                            <div class="col-xl-7 col-lg-12 col-sm-7 lg-mb-30px md-mb-0">
                                <p class="mb-0 fs-14 lh-22 text-center text-sm-start">Kami tidak akan pernah mengumpulkan informasi
                                    tentang Anda tanpa persetujuan eksplisit dari Anda.</p>
                            </div>
                            <div
                                class="col-xl-5 col-lg-12 col-sm-5 text-center text-sm-end text-lg-start text-xl-end xs-mt-25px">
                                <button class="btn btn-dark-gray btn-medium btn-round-edge btn-box-shadow" id="btn-submit"
                                    type="submit">Kirim pesan</button>
                            </div>
                            <div class="col-12 mt-20px mb-0 text-center text-md-start">
                                <div id="form-results" class="d-none"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="shape-image-animation p-0 w-100 bottom-minus-40px xl-bottom-0px d-none d-md-block">
            <svg xmlns="http://www.w3.org/2000/svg" widht="3000" height="400" viewBox="0 180 2500 200"
                fill="#ffffff">
                <path class="st1" d="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250">
                    <animate attributeName="d" dur="5s"
                        values="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250;
                            M 0 250 C 400 50 400 400 3000 250 L 3000 550 L 0 550 L 0 250;
                            M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250"
                        repeatCount="indefinite" />
                </path>
            </svg>
        </div>
    </section>
    <!-- end section -->
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Koordinat lokasi (ganti sesuai kebutuhan)
            var lat = @json($setting_web->latitude);
            var lng = @json($setting_web->longitude);

            // Inisialisasi map
            var map = L.map('leaflet-map').setView([lat, lng], 17);

            // Tambahkan tile layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Tambahkan marker dengan popup
            var marker = L.marker([lat, lng]).addTo(map);

            // Popup content
            var popupContent = '<div style="text-align: center; min-width: 200px;">' +
                '<strong style="font-size: 16px; color: #333; display: block; margin-bottom: 8px;">Sekretariat ' + @json($setting_web->name) + '</strong>' +
                '<p style="margin: 0 0 10px 0; color: #666; font-size: 14px;">' + @json($setting_web->address) +
                '</p>' +
                '<a href="https://maps.google.com/maps?ll=' + lat + ',' + lng + '&z=17&t=m" ' +
                'target="_blank" ' +
                'style="display: inline-block; padding: 6px 12px; background: #007bff; color: #fff; text-decoration: none; border-radius: 4px; font-size: 12px;">LIHAT DI PETA GOOGLE</a>' +
                '</div>';

            marker.bindPopup(popupContent, {
                maxWidth: 300,
                className: 'custom-popup'
            }).openPopup();
        });

        // Contact Form AJAX
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const btnSubmit = document.getElementById('btn-submit');
            const formResults = document.getElementById('form-results');

            // Disable button dan tampilkan loading
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

            // Reset form results
            formResults.classList.add('d-none');
            formResults.innerHTML = '';

            // Kirim AJAX request
            fetch('{{ route("contact.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: document.getElementById('inputName').value,
                    email: document.getElementById('inputEmail').value,
                    phone: document.getElementById('inputPhone').value,
                    subject: document.getElementById('inputSubject').value,
                    message: document.getElementById('inputMessage').value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Sukses
                    formResults.classList.remove('d-none');
                    formResults.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                    form.reset();
                } else {
                    // Error dari server
                    formResults.classList.remove('d-none');
                    formResults.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Terjadi kesalahan. Silakan coba lagi.') + '</div>';
                }
            })
            .catch(error => {
                // Validasi error atau network error
                if (error.message) {
                    formResults.classList.remove('d-none');
                    formResults.innerHTML = '<div class="alert alert-danger">' + error.message + '</div>';
                } else {
                    formResults.classList.remove('d-none');
                    formResults.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>';
                }
            })
            .finally(() => {
                // Enable button kembali
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'Kirim pesan';
            });
        });
    </script>
@endsection
