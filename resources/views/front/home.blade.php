
    @extends('front.layout.app')

@section('title')
    الصفحة الرئيسية
@endsection

    @section('front_content')



    <!-- Hero Section -->

@php
    $firstSlider = $sliders->first(); // نجيب أول Slider
@endphp

<div id="heroCarousel" class="carousel slide carousel-fade hero-section" data-bs-ride="carousel"  data-bs-interval="3000">

    <div class="carousel-inner">
        @foreach ($sliders as $key => $slider)
            <div class="carousel-item @if($key == 0) active @endif"
                 style="
                    background-image:
                        linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.4)),
                        url('{{ asset('images/sliders/' . $slider->image) }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                 ">
                <div class="container hero-content">
                    <div class="row">
                        <div class="col-lg-8 mx-auto text-center">

                            <h1 class="display-3 fw-bold text-white mb-4">
                      {{ $slider->big_title }}
                            </h1>

                            <p class="lead text-white mb-5">
                                {{ $slider->small_title }}
                            </p>

                            <div class="hero-buttons">
                                <a href="#qrcode" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-qrcode"></i> مسح الباركود
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <!-- Controls -->
    @if($sliders->count() > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon " aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next " type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon " aria-hidden="true"></span>
    </button>

    @endif
</div>


    <!-- Features Section -->
    <section class="features-section py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-title">لماذا نحن الأفضل؟</h2>
                    <p class="text-muted">نقدم لك تجربة طعام لا تُنسى</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>جودة عالية</h4>
                        <p class="text-muted">نستخدم أجود المكونات الطازجة</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4>توصيل سريع</h4>
                        <p class="text-muted">خدمة توصيل سريعة لجميع المناطق</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>فريق محترف</h4>
                        <p class="text-muted">   خبراء في تقديم أشهى المأكولات</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- QR Code Section -->
    <section id="qrcode" class="qrcode-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="qrcode-card text-center p-5">
                        <h3 class="mb-4">امسح الباركود لعرض المنيو</h3>
                        <div class="qr-container mb-4">
                            <div id="qrcode-display" class="qr-placeholder">
                                <a href="{{ $appUrl }}" target="_blank" class="d-inline-block mt-3">
    {!! QrCode::size(250)->generate($appUrl) !!}
</a>


                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Dishes -->
    <section class="popular-dishes py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-title">  المنتجات العشوية </h2>

                </div>
            </div>
            <div class="row g-4">
                @foreach ($products as $product )


                <div class="col-md-4">
                    <div class="dish-card">

                              <div class=" text-center">
            <img src="{{ $product->image ? asset('images/'.$product->image) : asset('images/default.jpg') }}"
                 alt="{{ $product->name }}"
                 class="img-fluid rounded-top"
                 style="height:200px; object-fit:cover; width:100%;">
        </div>
                        <div class="dish-info p-4">
                            <h5> {{ $product->name }}</h5>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="d-block text-center fs-5 fw-bold mb-2">{{ $product->price }} جنية</span>

                            </div>
                        </div>
                    </div>
                </div>

                    @endforeach
            </div>
        </div>
    </section>

    @endsection
