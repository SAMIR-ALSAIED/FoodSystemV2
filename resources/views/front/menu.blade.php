@extends('front.layout.app')

@section('title', 'قائمة الطعام المميزة')

@section('front_content')

<style>
    :root {
        --primary: #ff8c00;
        --primary-light: #fff4e6;
        --dark: #0f172a;
        --gray-text: #64748b;
        --radius: 18px;
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body { background: #f8fafc; 
            font-family: 'Cairo', sans-serif;

        direction: rtl; 
    
    }

    /* لودر علوي نحيف جداً */
    #top-loader {
        position: fixed; top: 0; left: 0; width: 0%; height: 3px; 
        z-index: 9999; transition: width 0.4s ease;
    }

    /* كارت المنتج المطور */
    .product-list-card { 
        background: #fff; border-radius: var(--radius); padding: 12px; 
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 16px; border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01);
        transition: var(--transition);
        position: relative;
    }
    
    .product-list-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.06);
        border-color: var(--primary-light);
    }

    .p-img-wrapper { 
        width: 90px; height: 90px; min-width: 90px; 
        border-radius: 14px; overflow: hidden; 
        background: #f1f5f9;
    }
    .p-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .product-list-card:hover .p-img-wrapper img { transform: scale(1.1); }

    .p-info { flex-grow: 1; min-width: 0; }
    .p-sub-category { 
        font-size: 0.7rem; color: var(--primary); font-weight: 700; 
        background: var(--primary-light); display: inline-block;
        padding: 2px 8px; border-radius: 6px; margin-bottom: 5px;
    }
    .p-name { 
        font-size: 1.05rem; font-weight: 800; color: var(--dark); 
        margin: 0; line-height: 1.4;
    }
    .p-price { 
        font-size: 1.2rem; font-weight: 900; color: var(--dark); 
        margin-top: 6px; display: flex; align-items: baseline; gap: 3px;
    }
    .p-price small { font-size: 0.75rem; color: var(--gray-text); font-weight: 600; }

    /* زر الإضافة */
    .p-action { margin-right: auto; } 
    .add-to-cart-btn { 
        background: var(--dark); color: #fff; border: none; 
        width: 44px; height: 44px; border-radius: 14px; 
        display: flex; align-items: center; justify-content: center; 
        transition: var(--transition); box-shadow: 0 4px 6px rgba(15, 23, 42, 0.1);
    }
    .add-to-cart-btn:hover { background: var(--primary); transform: rotate(90deg); }
    .add-to-cart-btn:active { transform: scale(0.9); }

    /* التصنيفات للموبايل */
    .mobile-nav-scroll { 
        display: flex; overflow-x: auto; gap: 10px; padding: 12px; background: #fff; 
       margin-top: 15px;
        position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid #f1f5f9; scrollbar-width: none;
    }
    .pill-link { 
        padding: 8px 18px; background: #f1f5f9; border-radius: 50px; 
        white-space: nowrap; color: var(--gray-text); font-weight: 700; 
        text-decoration: none !important; font-size: 0.9rem; transition: var(--transition);
    }
    .pill-link.active { background: var(--primary); color: #fff; box-shadow: 0 4px 10px rgba(255,140,0,0.2); }

    /* الترقيم (Pagination) */
    .ajax-pagination .page-link { border: none; background: transparent; color: var(--dark); font-weight: 700; border-radius: 10px !important; margin: 0 2px; }
    .ajax-pagination .page-item.active .page-link { background: var(--primary); color: #fff; }

    #products-wrapper { transition: opacity 0.2s ease; }
    .loading-opacity { opacity: 0.4; pointer-events: none; }
    
    @media (max-width: 768px) {
        .product-list-card { padding: 10px; gap: 12px; }
        .p-img-wrapper { width: 80px; height: 80px; min-width: 80px; }
        .p-name { font-size: 0.95rem; }
        .add-to-cart-btn { width: 40px; height: 40px; }
    }
</style>

<div id="top-loader"></div>

<div class="mobile-nav-scroll d-md-none">
    <a href="javascript:void(0)" data-url="{{ route('front.menu') }}" class="pill-link filter-btn {{ empty($categoryId) ? 'active' : '' }}">الكل</a>
    @foreach($categories as $cat)
        <a href="javascript:void(0)" data-url="{{ route('front.menu.filter', $cat->id) }}" class="pill-link filter-btn {{ isset($categoryId) && $categoryId == $cat->id ? 'active' : '' }}">
            {{ $cat->name }}
        </a>
    @endforeach
</div>

<div class="container py-4">
    <div class="row">
        {{-- الديسكتوب سايدبار بشكله الجديد --}}
        <div class="col-md-3 d-none d-md-block">
            <div class="sticky-top" style="top: 90px;">
                <h6 class="fw-bold mb-3 text-muted px-2">التصنيفات</h6>
                <div class="list-group list-group-flush shadow-sm rounded-4 overflow-hidden border">
                    <a href="javascript:void(0)" data-url="{{ route('front.menu') }}" class="list-group-item list-group-item-action border-0 filter-btn py-3 fw-bold {{ empty($categoryId) ? 'active bg-warning text-white' : '' }}">
                        <i class="fas fa-border-all me-2"></i> الكل
                    </a>
                    @foreach($categories as $cat)
                        <a href="javascript:void(0)" data-url="{{ route('front.menu.filter', $cat->id) }}" class="list-group-item list-group-item-action border-0 filter-btn py-3 fw-bold {{ isset($categoryId) && $categoryId == $cat->id ? 'active bg-warning text-white' : '' }}">
                            <i class="fas fa-utensils me-2"></i> {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex align-items-center justify-content-between mb-4 px-1">
                <h4 class="fw-black m-0" id="current-cat-title">
                    {{ isset($categoryId) ? $categories->where('id', $categoryId)->first()->name : 'قائمة الطعام' }}
                </h4>
            </div>

            <div id="products-wrapper">
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-12">
                            <div class="product-list-card">
                                <div class="p-img-wrapper">
                                    <img src="{{ $product->image ? asset('images/'.$product->image) : asset('images/default.jpg') }}" alt="{{ $product->name }}" loading="lazy">
                                </div>
                                <div class="p-info">
                                    <span class="p-sub-category">{{ $product->category->name ?? 'وجبة' }}</span>
                                    <h2 class="p-name">{{ $product->name }}</h2>
                                    <div class="p-price">{{ number_format($product->price, 0) }} <small>جنية</small></div>
                                </div>
                                <div class="p-action">
                                    <form class="ajax-form-cart" action="{{ route('front.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="add-to-cart-btn"><i class="fas fa-plus"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <img src="{{ asset('images/no-results.png') }}" style="width: 120px; opacity: 0.5;">
                            <p class="text-muted mt-3">عذراً، لا توجد وجبات في هذا القسم حالياً</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4 d-flex justify-content-center ajax-pagination">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- رسالة النجاح (Toast) --}}
<div id="cart-toast" style="position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); background: var(--dark); color: #fff; padding: 12px 24px; border-radius: 50px; z-index: 10000; display: none; box-shadow: 0 10px 25px rgba(0,0,0,0.2); font-weight: 800;">
    <i class="fas fa-check-circle text-warning me-2"></i> تمت الإضافة للسلة بنجاح
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    function quickLoad(url) {
        $("#top-loader").css("width", "40%");
        $("#products-wrapper").addClass("loading-opacity");

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $("#top-loader").css("width", "100%");
                const newContent = $(response);
                $('#products-wrapper').html(newContent.find('#products-wrapper').html());
                $('#current-cat-title').text(newContent.find('#current-cat-title').text());
                
                window.history.pushState(null, null, url);
                
                setTimeout(() => {
                    $("#top-loader").css("width", "0%");
                    $("#products-wrapper").removeClass("loading-opacity");
                }, 150);
            }
        });
    }

    $(document).on('click', '.filter-btn', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        $('.filter-btn').removeClass('active bg-warning text-white');
        $(this).addClass('active bg-warning text-white');
        quickLoad(url);
    });

    $(document).on('click', '.ajax-pagination a', function(e) {
        e.preventDefault();
        quickLoad($(this).attr('href'));
        window.scrollTo({ top: 0, behavior: 'instant' });
    });

    $(document).on('submit', '.ajax-form-cart', function(e) {
        e.preventDefault();
        const btn = $(this).find('button');
        const icon = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin"></i>');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if (window.updateCartCount) window.updateCartCount(res.cart_count);
                $('#cart-toast').stop().fadeIn(300).delay(2000).fadeOut(300);
                btn.html('<i class="fas fa-check"></i>').css('background', '#10b981');
                setTimeout(() => {
                    btn.prop('disabled', false).html(icon).css('background', '');
                }, 1200);
            }
        });
    });
});

// هذا الكود يكتشف إذا كان المستخدم عاد للخلف وكانت الصفحة "مخزنة"
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            // إذا اكتشفنا أن المستخدم رجع للخلف، ننعش الصفحة فوراً
            window.location.reload();
        }
    });

    // تأكد أيضاً من تصفير حالة الأزرار يدوياً فور تحميل الصفحة
    $(document).ready(function() {
        $('.add-to-cart-btn').prop('disabled', false);
        $('#submit-btn').prop('disabled', false).text('إرسال الطلب الآن');
    });
</script>

@endsection