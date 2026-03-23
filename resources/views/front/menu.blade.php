@extends('front.layout.app')

@section('title','المنيو')

@section('front_content')

    <link rel="stylesheet" href="{{ asset('front')}}/css/menu.css">


<!-- Page Header -->
<section class="page-header">
    <div class="container text-center">
        <h1>قائمة الطعام</h1>
   
    </div>
</section>

<!-- Menu Section -->
<section class="menu-section py-5">
    <div class="container">

        <!-- Category Filter -->
        <div class="menu-filters">
            <a href="{{ route('front.menu') }}"
               class="filter-pill {{ empty($categoryId) ? 'active' : '' }}">
                الكل
            </a>

            @foreach($categories as $category)
                @if($category->products->count() > 0)
                    <a href="{{ route('front.menu.filter', $category->id) }}"
                       class="filter-pill {{ isset($categoryId) && $categoryId == $category->id ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endif
            @endforeach
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card">

                    <!-- Image -->
                    <div class="product-img-wrap">
                        <img src="{{ $product->image ? asset('images/'.$product->image) : asset('images/default.jpg') }}"
                             alt="{{ $product->name }}">
                    </div>

                    <!-- Body -->
                    <div class="product-body">

                        <!-- Name & Price in one row -->
                        <div class="name-price">
                            <h5 class="product-name">{{ $product->name }}</h5>
                            <span class="price-tag " >{{ $product->price }} ج</span>
                        </div>

                        <!-- Add to Cart -->
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
                    <p>لا توجد منتجات في هذا القسم</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="menu-pagination">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>

    </div>
</section>

@endsection