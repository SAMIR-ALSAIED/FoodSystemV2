@extends('front.layout.app')

@section('title')
سلة التسوق
@endsection

@section('front_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front')}}/css/cart.css">

    <div class="container py-5 mt-5">
        <div id="cartContent">
            @if (empty($cart) || count($cart) == 0)
                {{-- واجهة السلة الفارغة --}}
                <div class="text-center py-5 card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <img src="https://cdn-icons-png.flaticon.com/512/11629/11629562.png" width="120" class="mb-4 opacity-75">
                        <h3 class="fw-bold">السلة فارغة حالياً</h3>
                        <a href="{{ route('front.menu')}}" class="btn btn-warning px-5 py-3 fw-bold rounded-pill mt-3">تصفح المنتجات الآن</a>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="cart-wrapper shadow-sm card border-0 rounded-4 p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0">المنتجات (<span id="cart-count">{{ count($cart) }}</span>)</h4>
                                <button type="button" onclick="confirmClearCart()" class="btn btn-link text-danger text-decoration-none p-0 small">
                                    <i class="fas fa-trash-alt me-1"></i> مسح السلة بالكامل
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="text-muted small">
                                        <tr>
                                            <th>المنتج</th>
                                            <th class="text-center">الكمية</th>
                                            <th class="text-center">السعر</th>
                                            <th class="text-end">الإجمالي</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalPrice = 0; @endphp
                                        @foreach ($cart as $id => $item)
                                            @php
                                                $subtotal = $item['price'] * $item['quantity'];
                                                $totalPrice += $subtotal;
                                            @endphp
                                            <tr id="row-{{ $id }}">
                                                <td class="py-4">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('images/' . $item['image']) }}" class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <h6 class="mb-0 fw-bold">{{ $item['name'] }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-center update-qty mx-auto" 
                                                           style="width: 70px;" data-id="{{ $id }}" data-price="{{ $item['price'] }}" 
                                                           value="{{ $item['quantity'] }}" min="1">
                                                </td>
                                                <td class="text-center fw-semibold text-muted">{{ $item['price'] }} ج</td>
                                                <td class="text-end fw-bold text-dark">
                                                    <span class="item-subtotal" id="subtotal-{{ $id }}">{{ $subtotal }}</span> ج
                                                </td>
                                                <td class="text-end">
                                                    <button class="btn btn-link text-danger remove-item" data-id="{{ $id }}"><i class="far fa-trash-can"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- معلومات التوصيل مع spans الأخطاء --}}
                        <div class="shipping-form shadow-sm card border-0 rounded-4 p-4 mt-4">
                            <h5 class="fw-bold mb-4"><i class="fas fa-map-marker-alt text-warning me-2"></i> معلومات التوصيل</h5>
                            <form id="checkoutForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small fw-bold mb-1">الاسم بالكامل</label>
                                        <input type="text" name="name" class="form-control border-0 bg-light py-2" placeholder="أدخل اسمك">
                                        <span class="text-danger small error-text name_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold mb-1">رقم الموبايل</label>
                                        <input type="text" name="phone" class="form-control border-0 bg-light py-2" placeholder="01xxxxxxxxx">
                                        <span class="text-danger small error-text phone_error"></span>
                                    </div>
                                    <div class="col-12">
                                        <label class="small fw-bold mb-1">البريد الإلكتروني</label>
                                        <input type="email" name="email" class="form-control border-0 bg-light py-2" placeholder="name@example.com">
                                        <span class="text-danger small error-text email_error"></span>
                                    </div>
                                    <div class="col-12">
                                        <label class="small fw-bold mb-1">العنوان بالتفصيل</label>
                                        <textarea name="address" class="form-control border-0 bg-light" rows="3" placeholder="الشارع / رقم المبنى / الطابق"></textarea>
                                        <span class="text-danger small error-text address_error"></span>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" id="submitOrder" class="btn btn-warning w-100 py-3 fw-bold rounded-pill shadow-sm">
                                            إرسال الطلب الآن <i class="fas fa-chevron-left ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- ملخص الحساب --}}
                    <div class="col-lg-4">
                        <div class="summary-card card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                            <h5 class="fw-bold mb-4">ملخص الطلب</h5>
                          
                          
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 fw-bold text-warning">الإجمالي </span>
                                <span class="h4 fw-bold text-warning"><span class="grand-total text-warning">{{ $totalPrice }}</span> ج</span>
                            </div>
                            <p class="small text-center mt-4 text-white">
                                <i class="fas fa-truck-moving me-1"></i> يتم التوصيل خلال 30-60 دقيقة
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- فورم مسح السلة --}}
    <form id="clearCartForm" action="{{ route('front.cart.clear') }}" method="POST" style="display:none;">@csrf</form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // تحديث المجموع
        function updateGrandTotal() {
            let total = 0;
            $('.item-subtotal').each(function() { total += parseFloat($(this).text()); });
            $('.grand-total').text(total.toFixed(2));
        }

        // مسح السلة
        function confirmClearCart() {
            Swal.fire({
                title: 'تفريغ السلة؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، امسح',
                cancelButtonText: 'إلغاء'
            }).then((result) => { if (result.isConfirmed) $('#clearCartForm').submit(); });
        }

        // تحديث الكمية
        $(document).on('input', '.update-qty', function() {
            let id = $(this).data('id'), price = parseFloat($(this).data('price')), qty = parseInt($(this).val());
            if (qty < 1 || isNaN(qty)) return;
            $(`#subtotal-${id}`).text((qty * price).toFixed(2));
            updateGrandTotal();
            $.post("{{ route('front.cart.update') }}", { _token: '{{ csrf_token() }}', id: id, quantity: qty });
        });

        // حذف عنصر
        $(document).on('click', '.remove-item', function() {
            let id = $(this).data('id');
            $.get("{{ url('cart/remove') }}/" + id, function() { location.reload(); });
        });

        // إرسال الفورم ومعالجة أخطاء الـ Validation تحت كل Input
        $('#checkoutForm').on('submit', function(e) {
            e.preventDefault();
            let btn = $('#submitOrder');
            
            // تنظيف الأخطاء السابقة
            $('.error-text').text('');
            $('.form-control').removeClass('is-invalid');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...');

            $.ajax({
                url: "{{ route('front.cart.checkout') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    Swal.fire({ title: 'شكراً لك!', text: res.message, icon: 'success', showConfirmButton: false });
                    setTimeout(() => window.location.href = "{{ url('/') }}", 2000);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('إرسال الطلب الآن');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $(`[name="${key}"]`).addClass('is-invalid'); // تلوين الإدخال بالأحمر
                            $(`.${key}_error`).text(value[0]); // وضع الرسالة في الـ span
                        });
                    } else {
                        Swal.fire('خطأ', 'حدث خلل ما، حاول مرة أخرى', 'error');
                    }
                }
            });
        });
    </script>
@endsection