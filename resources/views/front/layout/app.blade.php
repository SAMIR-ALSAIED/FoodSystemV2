<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title')</title>

    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('front')}}/css/style.css">
</head>
<body>
    <!-- Navigation -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">

            <a class="navbar-brand {{ request()->is('/') ? 'active' : '' }}" href="{{ route('front.home') }}">
    <i class="fas fa-utensils"></i> مطعمنا
</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
<a class="nav-link {{ request()->routeIs('front.home') ? 'active' : '' }}" href="{{ route('front.home') }}">الرئيسية</a>                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('front.menu') ? 'active' : '' }}" 
   href="{{ route('front.menu') }}" 
   style="{{ request()->routeIs('front.menu') ? 'active' : '' }}">
   قائمة الطعام
</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('front.reservation.*') ? 'active' : '' }}" 
   href="{{ route('front.reservation.create') }}">
   الحجوزات
</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="contact.html">اتصل بنا</a>
                    </li> --}}

                    <a href="{{ route('front.cart.index') }}" 
   class="btn {{ request()->routeIs('front.cart.index') ? 'btn-warning text-white' : 'btn-light' }} position-relative">
   <i class="fas fa-shopping-cart"></i> 


    @if(session('cart') && count(session('cart')) > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ count(session('cart')) }}
        </span>
    @endif
</a>



                </ul>
            </div>
        </div>
    </nav>


    @yield('front_content')


    <!-- Footer -->
<footer class="footer bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">
            <!-- عن المطعم -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold"><i class="fas fa-utensils"></i> مطعمنا</h5>
                <p class="text-light">
                    نقدم أشهى الاكلات  مع خدمة ممتازة وأجواء مريحة لعائلتك وأصدقائك.
                </p>
            </div>

            <!-- روابط سريعة -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">روابط سريعة</h5>
                <ul class="list-unstyled">
                    <li><a href="index.html" class="text-light text-decoration-none">الرئيسية</a></li>
                    <li><a href="menu.html" class="text-light text-decoration-none">قائمة الطعام</a></li>
                    <li><a href="about.html" class="text-light text-decoration-none">من نحن</a></li>
                    <li><a href="contact.html" class="text-light text-decoration-none">اتصل بنا</a></li>
                </ul>
            </div>

            <!-- تواصل معنا -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">تواصل معنا</h5>
                <p class="text-light mb-1">
                    <i class="fas fa-phone me-2"></i> 01225399159
                </p>
                <p class="text-light mb-1">
                    <i class="fas fa-envelope me-2"></i> samiralsaied07@gmail.com

                </p>
                <p class="text-light mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i>  طنطا
                </p>
            </div>
        </div>

        <hr class="border-light">

        <!-- حقوق النشر -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3">
            <p class="mb-0 text-light">&copy; 2026 مطعمنا . جميع الحقوق محفوظة.</p>
            <p class="mb-0 text-light">أفضل تجربة طعام لعائلتك وأصدقائك!</p>
        </div>
    </div>
</footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('front')}}/js/main.js"></script>
</body>
</html>
