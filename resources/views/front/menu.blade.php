@extends('front.layout.app')

@section('title','المنيو')

@section('front_content')


<!-- Page Header -->
<section class="page-header bg-dark py-5 mt-5">
    <div class="container text-center">
        <h1 class="text-white display-5 fw-bold">قائمة الطعام</h1>
        <p class="text-white lead">اختر من بين أشهى الأطباق لدينا</p>
    </div>
</section>

<!-- Menu Section -->
<section class="menu-section py-5">
    <div class="container">

        <!-- Category Filter -->
        <div class="row mb-5">
            <div class="col-12 text-center">

                <a href="{{ route('front.menu') }}"
                   class="btn btn-outline-primary mx-1 {{ empty($categoryId) ? 'active fw-bold text-decoration-underline' : '' }}">
                    الكل
                </a>

                @foreach($categories as $category)
                  
                     @if($category->products->count() > 0) <!-- شرط يظهر القسم لو فيه منتجات -->
                <a href="{{ route('front.menu.filter', $category->id) }}"
                   class="btn btn-outline-primary mx-1 {{ isset($categoryId) && $categoryId == $category->id ? 'active fw-bold text-decoration-underline' : '' }}">
                    {{ $category->name }}
                </a>
            @endif
                @endforeach

            </div>
        </div>

        <!-- Products -->
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 d-flex flex-column">

                        <!-- Image -->
                        <img src="{{ $product->image ? asset('images/'.$product->image) : asset('images/default.jpg') }}"
                             class="card-img-top rounded-top" alt="{{ $product->name }}" style="height:200px; object-fit:cover;">

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column flex-grow-1">
                            <h5 class="card-title text-center mb-3">{{ $product->name }}</h5>
<div class="mt-auto">
    <span class="d-block text-center fs-5 fw-bold mb-2">{{ $product->price }} جنية</span>

    <form action="{{ route('front.cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1">

        <button type="submit"
            class="btn btn-success w-100 d-flex align-items-center justify-content-center">
            <i class="fas fa-cart-plus me-2"></i> اضافة الاوردر
        </button>
    </form>
</div>


                        </div>

                    </div>
                </div>
            @empty
                <p class="text-center text-muted fs-5">لا توجد منتجات</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>

    </div>
</section>

@endsection
