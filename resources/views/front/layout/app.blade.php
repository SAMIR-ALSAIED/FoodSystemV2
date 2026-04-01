<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front')}}/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('front.home') }}">
            <i class="fas fa-utensils me-2"></i> مطعمنا
        </a>

        <div class="d-flex align-items-center d-lg-none">
            <a href="{{ route('front.cart.index') }}" class="btn btn-light position-relative me-3 py-1 px-2">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count-mobile" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ (session('cart') && count(session('cart')) > 0) ? '' : 'd-none' }}" style="font-size: 0.6rem;">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('front.home') ? 'active' : '' }}" href="{{ route('front.home') }}">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('front.menu') ? 'active' : '' }}" href="{{ route('front.menu') }}">المنيو</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('front.reservation.*') ? 'active' : '' }}" href="{{ route('front.reservation.create') }}">حجز الطاولات</a>
                </li>
                
                <li class="nav-item d-none d-lg-block ms-lg-3">
                    <a href="{{ route('front.cart.index') }}" class="btn btn-light position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cart-count-desktop" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ (session('cart') && count(session('cart')) > 0) ? '' : 'd-none' }}">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    @yield('front_content')

    <footer class="footer bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold"><i class="fas fa-utensils"></i> مطعمنا</h5>
                <p class="text-light">
                    نقدم أشهى الاكلات  مع خدمة ممتازة وأجواء مريحة لعائلتك وأصدقائك.
                </p>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">روابط سريعة</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('front.home') }}" class="text-light text-decoration-none">الرئيسية</a></li>
                    <li><a href="{{ route('front.menu') }}" class="text-light text-decoration-none">قائمة الطعام</a></li>
                    <li><a href="#" class="text-light text-decoration-none">من نحن</a></li>
                    <li><a href="#" class="text-light text-decoration-none">اتصل بنا</a></li>
                </ul>
            </div>

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

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3">
            <p class="mb-0 text-light">&copy; 2026 مطعمنا . جميع الحقوق محفوظة.</p>
            <p class="mb-0 text-light">أفضل تجربة طعام لعائلتك وأصدقائك!</p>
        </div>
    </div>
</footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        window.updateCartCount = function(newCount) {
            const desktopBadge = $('#cart-count-desktop');
            const mobileBadge = $('#cart-count-mobile');

            if (newCount > 0) {
                desktopBadge.text(newCount).removeClass('d-none');
                mobileBadge.text(newCount).removeClass('d-none');
            } else {
                desktopBadge.addClass('d-none');
                mobileBadge.addClass('d-none');
            }
        };

        
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            // إذا اكتشفنا أن المستخدم رجع للخلف، ننعش الصفحة فوراً
            window.location.reload();
        }
    });

    $(document).ready(function() {
        $('.add-to-cart-btn').prop('disabled', false);
        $('#submit-btn').prop('disabled', false).text('إرسال الطلب الآن');
    });
        
    </script>
    
    <script src="{{ asset('front')}}/js/main.js"></script>

    
    @stack('scripts')
</body>
</html>