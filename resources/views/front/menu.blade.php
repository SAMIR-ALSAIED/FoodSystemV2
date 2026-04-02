@extends('front.layout.app')

@section('title', 'المنيو')

@section('front_content')

<style>
    :root {
        --primary: #ff8c00;
        --primary-light: #fff4e6;
        --success: #10b981;
        --dark: #0f172a;
        --gray-text: #64748b;
        --radius: 18px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body { 
        background: #f8fafc; 
        font-family: 'Cairo', sans-serif;
        direction: rtl; 
    }

    /* لودر علوي نحيف */
    #top-loader {
        position: fixed; top: 0; left: 0; width: 0%; height: 3px; 
        background: var(--primary); z-index: 9999; transition: width 0.4s ease;
    }

    /* كارت المنتج */
    .product-list-card { 
        background: #fff; border-radius: var(--radius); padding: 12px; 
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 16px; border: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition);
        position: relative;
    }
    
    .product-list-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 20px -5px rgba(0,0,0,0.08);
        border-color: var(--primary);
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
        font-size: 1.1rem; font-weight: 800; color: var(--dark); 
        margin: 0; line-height: 1.4;
    }
    .p-price { 
        font-size: 1.2rem; font-weight: 900; color: var(--dark); 
        margin-top: 6px; display: flex; align-items: baseline; gap: 3px;
    }
    .p-price small { font-size: 0.75rem; color: var(--gray-text); font-weight: 600; }

    /* زر الإضافة */
    .add-to-cart-btn { 
        background: var(--dark); color: #fff; border: none; 
        width: 45px; height: 45px; border-radius: 14px; 
        display: flex; align-items: center; justify-content: center; 
        transition: var(--transition);
    }
    .add-to-cart-btn:hover { background: var(--primary); transform: scale(1.05); }
    .add-to-cart-btn:disabled { background: var(--success) !important; opacity: 1; }

    /* رسالة التنبيه (Toast) المحدثة */
    #cart-toast {
        position: fixed; bottom: 30px; left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: var(--dark); color: #fff;
        padding: 14px 25px; border-radius: 50px;
        z-index: 10000; display: flex; align-items: center; gap: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        font-weight: 700; opacity: 0; transition: var(--transition);
    }
    #cart-toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }

    /* التصنيفات للموبايل */
    .mobile-nav-scroll { 
        display: flex; overflow-x: auto; gap: 10px; padding: 12px; background: #fff; 
        position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid #f1f5f9;
        scrollbar-width: none;
    }
    .mobile-nav-scroll::-webkit-scrollbar { display: none; }
    .pill-link { 
        padding: 8px 20px; background: #f1f5f9; border-radius: 50px; 
        white-space: nowrap; color: var(--gray-text); font-weight: 700; 
        text-decoration: none !important; transition: var(--transition);
    }
    .pill-link.active { background: var(--primary); color: #fff; }

    #products-wrapper { transition: opacity 0.3s ease; }
    .loading-opacity { opacity: 0.5; pointer-events: none; }
</style>

<div id="top-loader"></div>

<div id="cart-toast">
    <i class="fas fa-check-circle text-warning"></i>
    <span>تمت إضافة الوجبة للسلة!</span>
</div>

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
        <div class="col-md-3 d-none d-md-block">
            <div class="sticky-top" style="top: 100px;">
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
                <h4 class="fw-bold m-0" id="current-cat-title">
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
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">لا توجد وجبات في هذا القسم حالياً</p>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    // وظيفة التحميل السريع AJAX
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
                }, 200);
            }
        });
    }

    // تبديل الأقسام
    $(document).on('click', '.filter-btn', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        $('.filter-btn').removeClass('active bg-warning text-white');
        $(this).addClass('active bg-warning text-white');
        quickLoad(url);
    });

    // الترقيم
    $(document).on('click', '.ajax-pagination a', function(e) {
        e.preventDefault();
        quickLoad($(this).attr('href'));
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // إضافة للسلة AJAX
    $(document).on('submit', '.ajax-form-cart', function(e) {
        e.preventDefault();
        const form = $(this);
        const btn = form.find('button');
        const originalIcon = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(res) {
                // إظهار التنبيه
                $('#cart-toast').addClass('show');
                
                // تحديث العداد العلوي إن وجد
                if (window.updateCartCount) window.updateCartCount(res.cart_count);
                
                // تغيير شكل الزر لعلامة صح
                btn.html('<i class="fas fa-check"></i>');

                setTimeout(() => {
                    $('#cart-toast').removeClass('show');
                    setTimeout(() => {
                        btn.prop('disabled', false).html(originalIcon);
                    }, 500);
                }, 2000);
            },
            error: function() {
                btn.prop('disabled', false).html(originalIcon);
                alert('حدث خطأ، حاول مرة أخرى');
            }
        });
    });
});

// التعامل مع زر الرجوع في المتصفح
window.addEventListener('pageshow', function(event) {
    if (event.persisted) window.location.reload();
});
</script>

@endsection