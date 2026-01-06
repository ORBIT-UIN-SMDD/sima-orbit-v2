 @php
     $category_news = \App\Models\NewsCategory::all();
     $member_fields = \App\Models\MemberField::all();
     $menu_profiles = \App\Models\MenuProfile::all();
 @endphp

 <header>
     <!-- start navigation -->
     <nav class="navbar navbar-expand-lg header-light header-reverse glass-effect" data-header-hover="light">
         <div class="container-fluid">
             <div class="col-auto col-xxl-3 col-lg-2 me-lg-0 me-auto">
                 <a class="navbar-brand" href="{{ route('home') }}">
                     <img src="images/demo-it-business-logo-white.png"
                         data-at2x="images/demo-it-business-logo-white@2x.png" alt="" class="default-logo">
                     <img src="images/demo-it-business-logo-black.png"
                         data-at2x="images/demo-it-business-logo-black@2x.png" alt="" class="alt-logo">
                     <img src="images/demo-it-business-logo-black.png"
                         data-at2x="images/demo-it-business-logo-black@2x.png" alt="" class="mobile-logo">
                 </a>
             </div>
             <div class="col-auto col-xxl-6 col-lg-8 menu-order position-static">
                 <button class="navbar-toggler float-start" type="button" data-bs-toggle="collapse"
                     data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                     <span class="navbar-toggler-line"></span>
                     <span class="navbar-toggler-line"></span>
                     <span class="navbar-toggler-line"></span>
                     <span class="navbar-toggler-line"></span>
                 </button>
                 <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                     <ul class="navbar-nav">
                         <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>



                         <li class="nav-item dropdown dropdown-with-icon-style02">
                             <a href="" class="nav-link">Profil</a>
                             <i class="fa-solid fa-angle-down dropdown-toggle" id="navbarDropdownMenuLink"
                                 role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                             <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 @foreach ($menu_profiles as $menu_profile)
                                     <li><a href="{{ route('profil.show', $menu_profile->slug) }}"><i
                                                 class="bi bi-menu-button"></i>{{ $menu_profile->name }}</a></li>
                                 @endforeach
                             </ul>
                         </li>
                         <li class="nav-item dropdown dropdown-with-icon-style02">
                             <a href="" class="nav-link">Bidang</a>
                             <i class="fa-solid fa-angle-down dropdown-toggle" id="navbarDropdownMenuLink"
                                 role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                             <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 @foreach ($member_fields as $member_field)
                                     <li><a href="{{ route('news.category', $member_field->slug) }}"><i
                                                 class="bi bi-gem"></i>{{ $member_field->name }}</a></li>
                                 @endforeach
                             </ul>
                         </li>
                         <li class="nav-item"><a href="demo-it-business-case-studies.html" class="nav-link">Tentang Kami</a></li>
                          <li class="nav-item dropdown dropdown-with-icon-style02">
                             <a href="{{ route("news.index") }}" class="nav-link">Berita</a>
                             <i class="fa-solid fa-angle-down dropdown-toggle" id="navbarDropdownMenuLink"
                                 role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                             <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 @foreach ($category_news as $category)
                                     <li><a href="{{ route('news.category', $category->slug) }}">
                                             @if (strtolower($category->name) == 'berita')
                                                 <i class="bi bi-newspaper"></i>
                                             @else
                                                 <i class="bi bi-folder"></i>
                                             @endif
                                             {{ $category->name }}
                                         </a></li>
                                 @endforeach
                             </ul>
                         </li>
                         <li class="nav-item"><a href="#" class="nav-link">Alumni</a></li>
                         <li class="nav-item"><a href="demo-it-business-contact.html" class="nav-link">Kontak Kami</a></li>
                     </ul>
                 </div>
             </div>
             <div class="col-auto col-xxl-3 col-lg-2 text-end d-none d-sm-flex">
                 <div class="header-icon">
                     <div class="header-button">
                         <a href="#modal-popup3"
                             class="btn btn-large text-dark btn-transparent-white-light btn-rounded text-transform-none border-1 popup-with-move-anim">SIMA-ORBIT
                             <i class="fa-solid fa-arrow-right"></i>
                         </a>
                     </div>
                 </div>
             </div>



         </div>
     </nav>
     <!-- end navigation -->
 </header>
 {{-- <div id="modal-popup3"
     class="zoom-anim-dialog mfp-hide col-xl-3 col-lg-6 col-md-7 col-11 mx-auto bg-white text-center modal-popup-main p-50px">
     <span class="text-dark-gray fw-600 fs-24 mb-10px d-block">Rotate animation</span>
     <p>Lorem ipsum is simply dummy text of the printing typesetting industry. Lorem ipsum has been the industry's
         standard dummy ever since.</p>
     <a class="btn btn-small btn-rounded btn-dark-gray popup-modal-dismiss mt-10px" href="#">Dismiss</a>
 </div> --}}
 <!-- Simple Login Form Modal -->
 <div id="modal-popup3"
     class="zoom-anim-dialog mfp-hide col-xl-3 col-lg-6 col-md-7 col-11 mx-auto bg-white text-center modal-popup-main p-50px">
     <span class="text-dark-gray fw-600 fs-24 mb-10px d-block">SIMA-ORBIT</span>
     <p class="mb-30px">Masuk ke SIMA-ORBIT dengan NIM/Email dan Password Anda</p>
     <form method="POST" action="{{ route('login') }}">
         @csrf
         <div class="mb-3 text-start">
             <input type="text" class="form-control" id="login" name="login" placeholder="NIM/Email" required
                 autofocus>
         </div>
         <div class="mb-3 text-start">
             <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
         </div>
         <div class="mb-3 text-end">
             <a href="" class="text-decoration-underline small">Lupa password?</a>
         </div>
         <button type="submit" class="btn btn-rounded w-100">Login</button>
     </form>
 </div>
