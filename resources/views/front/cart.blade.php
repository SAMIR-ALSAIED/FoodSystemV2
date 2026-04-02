@extends('front.layout.app')

@section('title', 'سلة الطلبات')

@section('front_content')

{{-- منع الكاش لضمان تحديث السلة دائماً --}}
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />

<style>
    :root {
        --primary: #ffc107;
        --primary-dark: #e5ac00;
        --dark: #1e272e;
        --soft-bg: #f4f7f6;
        --radius: 20px;
        --shadow: 0 15px 35px rgba(0,0,0,0.08);
        --danger: #ef5350;
        --white: #ffffff;
    }

    body { 
        background-color: var(--soft-bg);
        font-family: 'Cairo', sans-serif;
        direction: rtl; 
    }

    .cart-wrapper { max-width: 1200px; margin: 30px auto; padding: 15px; }

    /* رأس الصفحة */
    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .section-title {
        font-weight: 900;
        font-size: 1.6rem;
        color: var(--dark);
        margin: 0;
    }

    .btn-clear-all {
        background: #fff;
        color: var(--danger);
        border: 1px solid var(--danger);
        padding: 8px 18px;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
        font-size: 0.9rem;
    }
    .btn-clear-all:hover {
        background: var(--danger);
        color: #fff;
    }

    /* كروت المنتجات */
    .cart-card {
        background: var(--white); 
        border-radius: var(--radius); 
        padding: 15px; 
        margin-bottom: 15px;
        display: flex; 
        align-items: center; 
        box-shadow: var(--shadow);
        border: none;
        transition: transform 0.3s ease;
        position: relative;
    }

    .item-img { 
        width: 100px; height: 100px; 
        object-fit: cover; border-radius: 15px; 
        margin-left: 20px; 
    }

    .item-info { flex-grow: 1; }
    .item-name { 
        font-weight: 800; font-size: 1.1rem; 
        color: var(--dark); margin-bottom: 5px;
    }
    .unit-price-label { font-size: 0.9rem; color: #7f8c8d; font-weight: 600; }

    /* التحكم في الكمية */
    .qty-box {
        display: flex; align-items: center; 
        background: #f1f2f6; border-radius: 12px; 
        padding: 5px; margin: 0 15px;
    }
    .qty-btn {
        width: 32px; height: 32px; border-radius: 8px; border: none;
        background: #fff; color: var(--dark); transition: 0.2s; 
        display: flex; align-items: center; justify-content: center;
    }
    .qty-btn:hover { background: var(--primary); }
    .qty-val { width: 40px; text-align: center; font-weight: 800; border: none; background: transparent; }

    .price-area { text-align: left; min-width: 110px; }
    .item-total { font-weight: 900; font-size: 1.2rem; color: var(--dark); }

    /* زر الحذف الفردي */
    .btn-remove-item {
        color: #ced4da; font-size: 1.2rem; transition: 0.3s;
        background: none; border: none; padding: 5px 15px;
    }
    .btn-remove-item:hover { color: var(--danger); transform: scale(1.1); }

    /* بيانات التوصيل */
    .delivery-card {
        background: var(--white); border-radius: var(--radius); padding: 30px;
        box-shadow: var(--shadow); margin-top: 20px;
    }
    .form-floating-custom {
        background: #f8f9fa; border-radius: 12px; padding: 12px 15px;
        margin-bottom: 5px; border: 2px solid transparent; transition: 0.3s;
    }
    .form-floating-custom:focus-within { border-color: var(--primary); background: #fff; }
    .form-floating-custom.is-invalid-border { border-color: var(--danger); background: #fff8f8; }
    .form-floating-custom label { display: block; font-size: 0.8rem; font-weight: 700; color: #95a5a6; margin-bottom: 3px;}
    .form-floating-custom input { width: 100%; border: none; background: transparent; font-weight: 700; outline: none; color: var(--dark); }
    
    .laravel-error { display: block; color: var(--danger); font-size: 0.8rem; font-weight: 700; margin-bottom: 15px; }

    /* الفاتورة */
    .summary-box {
        background: var(--dark); color: #fff; border-radius: 25px;
        padding: 30px; position: sticky; top: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .summary-item { display: flex; justify-content: space-between; margin-bottom: 15px; opacity: 0.8; }
    .total-row { border-top: 1px solid #444; padding-top: 15px; margin-top: 15px; }

    .btn-confirm {
        background: var(--primary); color: #000; font-weight: 900; 
        width: 100%; border-radius: 15px; padding: 16px; border: none; 
        margin-top: 25px; transition: 0.3s; font-size: 1.1rem;
    }
    .btn-confirm:hover { background: var(--primary-dark); box-shadow: 0 10px 20px rgba(255,193,7,0.3); }

    .update-anim { animation: pulse 0.5s; }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); color: var(--primary); }
        100% { transform: scale(1); }
    }

    @media (max-width: 768px) {
        .cart-card { flex-direction: column; text-align: center; }
        .item-img { margin: 0 0 15px 0; width: 100%; height: 150px; }
        .qty-box { margin: 15px 0; }
        .btn-remove-item { position: absolute; top: 10px; left: 10px; }
    }
</style>

<div class="cart-wrapper">
    <div id="cart-content-area">
        @if(empty($cart) || count($cart) == 0)
            <div class="text-center py-5 bg-white rounded-5 shadow-sm">
                <div class="mb-4">
                    <i class="fas fa-shopping-basket fa-4x text-light"></i>
                </div>
                <h3 class="fw-black">سلة المشتريات فارغة</h3>
                <a href="{{ route('front.menu') }}" class="btn btn-warning rounded-pill px-5 py-3 mt-3 fw-black shadow-sm">ابدأ التسوق الآن</a>
            </div>
        @else
            <div class="cart-header">
                <h5 class="section-title">
                    <i class="fas fa-shopping-cart text-warning me-2"></i> سلة الطلبات ({{ count($cart) }})
                </h5>
                <button type="button" class="btn-clear-all" onclick="clearFullCart()">
                    <i class="fas fa-trash-alt me-1"></i> مسح السلة بالكامل
                </button>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div id="items-container">
                        @php $grandTotal = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php 
                                $subtotal = $item['price'] * $item['quantity']; 
                                $grandTotal += $subtotal;
                            @endphp
                            <div class="cart-card animate__animated animate__fadeIn" id="row-{{ $id }}">
                                <img src="{{ asset('images/' . $item['image']) }}" class="item-img shadow-sm">
                                
                                <div class="item-info">
                                    <div class="item-name">{{ $item['name'] }}</div>
                                    <div class="unit-price-label" data-price="{{ $item['price'] }}">
                                        {{ number_format($item['price']) }} ج.م
                                    </div>
                                </div>

                                <div class="qty-box">
                                    <button type="button" class="qty-btn" onclick="updateCart('{{ $id }}', -1)"><i class="fas fa-minus"></i></button>
                                    <input type="text" class="qty-val" id="qty-{{ $id }}" value="{{ $item['quantity'] }}" readonly>
                                    <button type="button" class="qty-btn" onclick="updateCart('{{ $id }}', 1)"><i class="fas fa-plus"></i></button>
                                </div>

                                <div class="price-area">
                                    <div class="item-total">
                                        <span id="sub-{{ $id }}">{{ number_format($subtotal) }}</span> 
                                        <small>ج.م</small>
                                    </div>
                                </div>

                                <button class="btn-remove-item" onclick="confirmDelete('{{ $id }}')" title="حذف المنتج">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="delivery-card">
                        <h6 class="fw-black mb-4"><i class="fas fa-truck text-warning me-2"></i> معلومات  التوصيل</h6>
                        <form id="orderForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating-custom" id="container_name">
                                        <label>الاسم بالكامل</label>
                                        <input type="text" name="name" id="field_name" placeholder="أدخل اسمك ">
                                    </div>
                                    <span class="laravel-error" id="err_name"></span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom" id="container_phone">
                                        <label>رقم الجوال</label>
                                        <input type="tel" name="phone" id="field_phone" placeholder="ادخل رقم الجوال">
                                    </div>
                                    <span class="laravel-error" id="err_phone"></span>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating-custom" id="container_address">
                                        <label>عنوان التوصيل التفصيلي</label>
                                        <input type="text" name="address" id="field_address" placeholder="ادخل العنوان    ">
                                    </div>
                                    <span class="laravel-error" id="err_address"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-box">
                        <h5 class="fw-black mb-4">ملخص الفاتورة</h5>
                        <div class="summary-item">
                            <span>إجمالي المنتجات</span>
                            <span id="summary-subtotal">{{ number_format($grandTotal) }} ج.م</span>
                        </div>
                    
                        <div class="total-row d-flex justify-content-between align-items-center mt-3 pt-3">
                            <span class="h5 fw-black mb-0">المجموع النهائي</span>
                            <div class="text-end">
                                <span class="h2 fw-black text-warning mb-0 total-val">{{ number_format($grandTotal) }}</span>
                                <span class="text-warning fw-bold small">ج.م</span>
                            </div>
                        </div>
                        <button type="button" onclick="processOrder(this)" class="btn-confirm shadow-lg">
                            إتمام الطلب الآن <i class="fas fa-chevron-left ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// تحديث الكمية
function updateCart(id, delta) {
    let qInput = $(`#qty-${id}`);
    let nextVal = parseInt(qInput.val()) + delta;
    if(nextVal < 1) return;

    $.ajax({
        url: "{{ route('front.cart.update') }}",
        method: "POST",
        data: { _token: '{{ csrf_token() }}', id: id, quantity: nextVal },
        success: function() {
            qInput.val(nextVal);
            let price = parseFloat($(`#row-${id} .unit-price-label`).data('price'));
            let newSub = price * nextVal;
            $(`#sub-${id}`).text(newSub.toLocaleString()).addClass('update-anim');
            setTimeout(() => $(`#sub-${id}`).removeClass('update-anim'), 500);
            calcTotal();
        }
    });
}

// حذف منتج واحد
function confirmDelete(id) {
    Swal.fire({
        title: 'حذف المنتج؟',
        text: "هل أنت متأكد من إزالة هذا المنتج من السلة؟",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef5350',
        cancelButtonColor: '#7f8c8d',
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء'
    }).then((result) => { if (result.isConfirmed) removeItem(id); });
}

function removeItem(id) {
    $.get("{{ url('cart/remove') }}/" + id, function() {
        $(`#row-${id}`).addClass('animate__animated animate__fadeOutRight');
        setTimeout(() => { 
            $(`#row-${id}`).remove(); 
            if($('.cart-card').length === 0) location.reload();
            else calcTotal();
        }, 500);
    });
}

// مسح السلة بالكامل


function clearFullCart() {
    Swal.fire({
        title: 'مسح السلة بالكامل؟',
        text: "سيتم حذف جميع المنتجات، هل أنت متأكد؟",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#ef5350',
        confirmButtonText: 'نعم، مسح الكل',
        cancelButtonText: 'تراجع'
    }).then((result) => {
        if (result.isConfirmed) {
            // استخدام $.post بدلاً من $.get وإرسال التوكن
            $.post("{{ route('front.cart.clear') }}", {
                _token: "{{ csrf_token() }}" 
            }, function(response) {
                location.reload(); 
            }).fail(function(xhr) {
                Swal.fire('خطأ', 'تعذر مسح السلة، حاول مرة أخرى', 'error');
            });
        }
    });
}

// حساب الإجمالي
function calcTotal() {
    let sum = 0;
    $('[id^="sub-"]').each(function() { 
        sum += parseFloat($(this).text().replace(/,/g, '')); 
    });
    $('.total-val').text(sum.toLocaleString()).addClass('update-anim');
    $('#summary-subtotal').text(sum.toLocaleString() + ' ج.م');
}

// إتمام الطلب
function processOrder(btn) {
    $('.laravel-error').text('');
    $('.form-floating-custom').removeClass('is-invalid-border');
    $(btn).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> جاري الطلب...');

    $.ajax({
        url: "{{ route('front.cart.checkout') }}",
        method: "POST",
        data: $('#orderForm').serialize(),
        success: function(response) {
            Swal.fire({
                title: 'تم الطلب بنجاح!',
                text: response.message || 'شكراً لك، سيصلك طلبك في أقرب وقت.',
                icon: 'success',
                confirmButtonColor: '#ffc107'
            }).then(() => { window.location.replace("{{ url('/') }}"); });
        },
        error: function(xhr) {
            $(btn).prop('disabled', false).html('إتمام الطلب الآن <i class="fas fa-chevron-left ms-2"></i>');
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $(`#err_${key}`).text(value[0]);
                    $(`#container_${key}`).addClass('is-invalid-border');
                });
            } else {
                Swal.fire('خطأ', xhr.responseJSON.message || 'حدثت مشكلة، حاول مرة أخرى', 'error');
            }
        }
    });
}
</script>

@endsection