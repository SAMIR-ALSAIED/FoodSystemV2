@extends('front.layout.app')

@section('title', 'الصفحة الرئيسية')

@section('front_content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('front/css/style.css') }}">

<div class="main-wrapper">

    {{-- ===== HERO SLIDER ===== --}}
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            @foreach ($sliders as $key => $slider)
            <div class="carousel-item @if($key == 0) active @endif">
                <div class="hero-section" style="background-image: url('{{ asset('images/sliders/' . $slider->image) }}');">
                    <div class="hero-overlay"></div>
                    <div class="hero-grain"></div>
                    <div class="container hero-content">
                 
                        <h1 class="hero-title animate__animated animate__fadeInUp">
                            {{ $slider->big_title }}
                        </h1>
                        <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                            {{ $slider->small_title }}
                        </p>
                        <div class="hero-cta animate__animated animate__fadeInUp animate__delay-2s">
                            <a href="{{ route('front.menu') }}" class="btn-royal">
                                <i class="fas fa-utensils"></i>
                                استكشف المنيو
                            </a>
                            <div class="scroll-hint">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if(count($sliders) > 1)
        <div class="carousel-indicators-custom">
            @foreach ($sliders as $key => $slider)
            <button data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}" @if($key == 0) class="active" @endif></button>
            @endforeach
        </div>
        <button class="carousel-arrow carousel-arrow-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <i class="fas fa-chevron-right"></i>
        </button>
        <button class="carousel-arrow carousel-arrow-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <i class="fas fa-chevron-left"></i>
        </button>
        @endif
    </div>

    {{-- ===== MENU SECTION ===== --}}
    <section id="menu" class="menu-section">
        <div class="container">
            <div class="section-header">
                <p class="section-eyebrow">يتجدد كل يوم</p>
                <h2 class="section-title"> منتجاتنا</h2>
            
            </div>

            <div class="menu-grid">
                @forelse ($products as $product)
                <div class="menu-card">
                    <div class="menu-card-img-wrap">
                        <img src="{{ $product->image ? asset('images/' . $product->image) : asset('images/default.jpg') }}"
                             alt="{{ $product->name }}"
                             loading="lazy">
                        <div class="card-img-shine"></div>
                    </div>
                    <div class="menu-card-body">
                        <div class="menu-card-top">
                            <h4 class="menu-card-name">{{ $product->name }}</h4>
                            <span class="menu-card-price">
                                {{ number_format($product->price) }}
                                <small>ج</small>
                            </span>
                        </div>
                        @if($product->description)
                        <p class="menu-card-desc">{{ Str::limit($product->description, 70) }}</p>
                        @endif
                        <div class="menu-card-footer">
                            <div class="menu-card-divider"></div>
                            <button class="btn-add-cart"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span>أضف للسلة</span>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-utensils"></i></div>
                    <p>نعمل حالياً على تحديث قائمتنا الملكية..</p>
                </div>
                @endforelse
            </div>

            <div class="view-all-wrap">
                <a href="{{ route('front.menu') }}" class="btn-outline-royal">
                    عرض المنيو بالكامل
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </section>
</div>

{{-- ===== TOAST ===== --}}
<div id="cart-toast">
    <i class="fas fa-check-circle"></i>
    <span id="toast-msg">تمت الإضافة بنجاح</span>
</div>

{{-- ===== AJAX CART ===== --}}
<script>
document.querySelectorAll('.btn-add-cart').forEach(btn => {
    btn.addEventListener('click', function () {
        const id   = this.dataset.id;
        const name = this.dataset.name;
        const self = this;

        self.disabled = true;
        self.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>جاري الإضافة...</span>';

        fetch('{{ route("front.cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: id, quantity: 1 })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                self.innerHTML = '<i class="fas fa-check"></i> <span>تمت الإضافة</span>';
                self.classList.add('added');

                // تحديث عداد السلة في الناف بار
                const cartCount = document.querySelector('.cart-count');
                if (cartCount && data.cart_count !== undefined) {
                    cartCount.textContent = data.cart_count;
                    cartCount.classList.add('bump');
                    setTimeout(() => cartCount.classList.remove('bump'), 400);
                }

                showToast('تمت إضافة ' + name + ' للسلة');

                setTimeout(() => {
                    self.disabled = false;
                    self.classList.remove('added');
                    self.innerHTML = '<i class="fas fa-shopping-cart"></i> <span>أضف للسلة</span>';
                }, 2000);

            } else {
                showToast(data.message || 'حدث خطأ، حاول مرة أخرى', true);
                resetBtn(self);
            }
        })
        .catch(() => {
            showToast('تعذّر الاتصال بالخادم', true);
            resetBtn(self);
        });
    });
});

function resetBtn(btn) {
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-shopping-cart"></i> <span>أضف للسلة</span>';
}

function showToast(msg, isError = false) {
    const toast    = document.getElementById('cart-toast');
    const toastMsg = document.getElementById('toast-msg');
    const icon     = toast.querySelector('i');

    toastMsg.textContent = msg;
    icon.className = isError ? 'fas fa-times-circle' : 'fas fa-check-circle';
    toast.style.background = isError
        ? 'linear-gradient(135deg,#c0392b,#e74c3c)'
        : 'linear-gradient(135deg,#ff8c00,#ffaa33)';

    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}
</script>

@endsection