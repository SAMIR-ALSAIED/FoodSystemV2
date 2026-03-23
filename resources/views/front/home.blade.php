
    @extends('front.layout.app')

@section('title')
    الصفحة الرئيسية
@endsection

    <link rel="stylesheet" href="{{ asset('front')}}/css/popular.css">


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
                                <a href="{{route('front.menu')}}" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-qrcode"></i> المنيو 
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



<section class="popular-dishes py-5">
    <div class="container">
        <div class="row text-center mb-4">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">المنتجات العشوائية</h2>
            </div>
        </div>

        <div class="products-grid">
            @forelse ($products as $product)
                <div class="product-card">
                    <div class="product-img-wrap">
                        <img
                            src="{{ $product->image ? asset('images/' . $product->image) : asset('images/default.jpg') }}"
                            alt="{{ $product->name }}">
                    </div>

                    <div class="product-body">
                        <div class="name-price">
                            <h5 class="product-name">{{ $product->name }}</h5>
                            <span class="price-tag">{{ $product->price }} ج</span>
                        </div>

                           <form action="{{ route('front.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="add-to-cart-btn">
                                <i class="fas fa-cart-plus"></i>
                                  اطلب الآن
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-utensils"></i>
                    <p>لا توجد منتجات متاحة حالياً</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

    @endsection
