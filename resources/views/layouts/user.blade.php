<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta content="width=device-width, initial-scale=1.0" name="viewport">

   <title>SMAN 1 Kepanjen</title>
   <meta content="" name="description">
   <meta content="" name="keywords">

   <!-- Favicons -->
   <link href="{{ asset('front/img/favicon.png') }}" rel="icon">
   <link href="{{ asset('front/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

   <!-- Google Fonts -->
   <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet">

   <!-- Vendor CSS Files -->
   <link href="{{ asset('front/vendor/aos/aos.css') }}" rel="stylesheet">
   <link href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ asset('front/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
   <link href="{{ asset('front/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
   <link href="{{ asset('front/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
   <link href="{{ asset('front/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

   <!-- Template Main CSS File -->
   <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">

</head>

<body>

   <!-- ======= Top Bar ======= -->
   <section id="topbar" class="d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
         <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope d-flex align-items-center"><a
                  href="mailto:contact@example.com">contact@example.com</a></i>
            <i class="bi bi-phone d-flex align-items-center ms-4"><span>(0341) 395122</span></i>
         </div>

         <div class="cta d-none d-md-flex align-items-center">
            <a href="{{ route('user.post', ['pengumuman']) }}" class="scrollto">Penggumuman</a>
         </div>
      </div>
   </section>

   <!-- ======= Header ======= -->
   <header id="header" class="d-flex align-items-center">
      <div class="container d-flex align-items-center justify-content-between">

         <div class="logo">
            <h1><a href="{{ route('user.index') }}">SMAN 1 KEPANJEN</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
         </div>

         <nav id="navbar" class="navbar">
            <ul>
               <li><a class="nav-link scrollto active" href="{{ route('user.index') }}">Beranda</a></li>
               <li class="dropdown"><a href="#"><span>Profil</span> <i class="bi bi-chevron-down"></i></a>
                  <ul>
                     <li><a href="#">Visi & Misi</a></li>
                     <li><a href="#">Struktur Organisasi</a></li>
                     <li><a href="#">Data Guru</a></li>
                     <li><a href="#">Data Siswa</a></li>
                  </ul>
               </li>
               <li class="dropdown"><a href="#"><span>Berita & Artikel</span> <i class="bi bi-chevron-down"></i></a>
                  <ul>
                     <li><a href="{{ route('user.post', ['berita']) }}">Berita</a></li>
                     <li><a href="{{ route('user.post', ['artikel']) }}">Artikel</a></li>
                     <li><a href="{{ route('user.post', ['pengumuman']) }}">Penggumuman</a></li>
                  </ul>
               </li>
               <li class="dropdown"><a href="#"><span>Kurikulum</span> <i class="bi bi-chevron-down"></i></a>
                  <ul>
                     <li><a href="#">Kelas X</a></li>
                     <li><a href="#">Kelas XI</a></li>
                     <li><a href="#">Kelas XII</a></li>
                  </ul>
               </li>
               <li class="dropdown"><a href="#"><span>Informasi PPDB</span> <i class="bi bi-chevron-down"></i></a>
                  <ul>
                     <li><a href="{{ route('user.postdetail', ['informasi-ppdb', 1]) }}">Informasi
                           PPDB</a></li>
                     <li><a href="#">Pendaftaran PPDB</a></li>
                     <li><a href="#">Hasil Penggumuman</a></li>
                  </ul>
               </li>
               <li><a class="nav-link scrollto" href="#contact">Kontak Kami</a></li>
               <li><a class="nav-link scrollto" href="{{ route('login') }}">E-learning</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
         </nav><!-- .navbar -->

      </div>
   </header><!-- End Header -->

   @yield('content')

   <!-- ======= Footer ======= -->
   <footer id="footer">

      <div class="footer-top">
         <div class="container">
            <div class="row">

               <div class="col-lg-3 col-md-6 footer-contact">
                  <h3>SMAN 1 KEPANJEN</h3>
                  <p>
                     Jl. Ahmad Yani No.48 <br>
                     Ardirejo, Kec. Kepanjen<br>
                     Malang, Jawa Timur 65163 <br><br>
                     <strong>Phone:</strong> (0341) 395122<br>
                     <strong>Email:</strong> info@example.com<br>
                  </p>
               </div>

               <div class="col-lg-2 col-md-6 footer-links">
                  <h4>Profil</h4>
                  <ul>
                     <li><i class="bx bx-chevron-right"></i> <a href="{{ route('user.index') }}">Home</a></li>
                     <li><i class="bx bx-chevron-right"></i> <a href="#">Visi & Misi</a></li>
                     <li><i class="bx bx-chevron-right"></i> <a href="#">Struktur Organisasi</a></li>
                     <li><i class="bx bx-chevron-right"></i> <a href="#">Data Guru</a></li>
                     <li><i class="bx bx-chevron-right"></i> <a href="#">Data Siswa</a></li>
                  </ul>
               </div>

               <div class="col-lg-3 col-md-6 footer-links">
                  <h4>Informasi PPDB</h4>
                  <ul>
                     <li><i class="bx bx-chevron-right"></i> <a href="#">Informasi PPDB</a></li>
                     <li><i class="bx bx-chevron-right"></i> <a href="#">Pendaftaran PPDB</a></li>
                     <li><i class="bx bx-chevron-right"></i> <a href="#">Hasil Penggumuman</a></li>
                  </ul>
               </div>

               <div class="col-lg-4 col-md-6 footer-newsletter">
                  <iframe class="img-fluid"
                     src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15799.090111900607!2d112.5723506!3d-8.1246271!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5b7ce72d64e096f8!2sSMAN%201%20KEPANJEN!5e0!3m2!1sid!2sid!4v1638397857601!5m2!1sid!2sid"
                     style="border:0;" width="400" height="500" allowfullscreen="" loading="lazy"></iframe>
               </div>

            </div>
         </div>
      </div>

      <div class="container d-lg-flex py-4">

         <div class="me-lg-auto text-center text-lg-start">
            <div class="copyright">
               &copy; Copyright <strong><span>SMAN 1 KEPANJEN</span></strong>. All Rights Reserved
            </div>
         </div>
         <div class="social-links text-center text-lg-right pt-3 pt-lg-0">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
         </div>
      </div>
   </footer><!-- End Footer -->

   <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
         class="bi bi-arrow-up-short"></i></a>

   <!-- Vendor JS Files -->
   <script src="{{ asset('front/vendor/aos/aos.js') }}"></script>
   <script src="{{ asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('front/vendor/glightbox/js/glightbox.min.js') }}"></script>
   <script src="{{ asset('front/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
   <script src="{{ asset('front/vendor/swiper/swiper-bundle.min.js') }}"></script>
   <script src="{{ asset('front/vendor/php-email-form/validate.js') }}"></script>

   <!-- Template Main JS File -->
   <script src="{{ asset('front/js/main.js') }}"></script>

</body>

</html>
