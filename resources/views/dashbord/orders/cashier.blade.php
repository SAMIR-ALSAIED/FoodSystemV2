<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شاشة الكاشير</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{asset('admin')}}/dist/css/cashier.css">

    <style>

    </style>
</head>
<body>

<div id="printArea">
    <div class="print-header">
        <h3 style="margin:0">مطعمنا</h3>
        <p style="margin:2px">تاريخ: <span id="printDate"></span></p>
        <p style="margin:2px">رقم الفاتورة: #<span id="printOrderNo">{{ $nextOrderId }}</span></p>
        <p style="margin:2px" id="printTableInfo"></p>
    </div>
    <table class="print-table">
        <thead>
            <tr>
                <th>الصنف</th>
                <th style="text-align:center">كمية</th>
                <th style="text-align:left">إجمالي</th>
            </tr>
        </thead>
        <tbody id="printBody"></tbody>
    </table>
    <div class="print-total">
        <div style="display:flex; justify-content:space-between">
            <span>الإجمالي:</span>
            <span id="printTotal">0.00</span>
        </div>
        <div style="display:flex; justify-content:space-between; font-weight:normal; font-size: 11px;">
            <span>المدفوع:</span>
            <span id="printPaid">0.00</span>
        </div>
        <div style="display:flex; justify-content:space-between; font-weight:normal; font-size: 11px;">
            <span>الباقي:</span>
            <span id="printChange">0.00</span>
        </div>
    </div>
    <div class="print-footer">شكراً لزيارتكم</div>
</div>

<header class="pos-header no-print">
    <div class="d-flex align-items-center gap-4">
        <h5 class="m-0 fw-bold d-flex align-items-center gap-2">
            <i class="bi bi-cpu-fill text-primary"></i> شاشة الكاشير
        </h5>
        <div class="search-container">
            <i class="bi bi-search"></i>
            <input type="text" id="productSearch" placeholder="بحث عن منتج (F2)...">
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="text-end line-height-1">
            <div id="liveClock" class="fw-bold small"></div>
            <span class="text-white" style="font-size: 11px;">كاشير: {{ auth()->user()->name }}</span>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-pill-direct">
                <i class="bi bi-box-arrow-right"></i> خروج
            </button>
        </form>
    </div>
</header>

<div class="pos-main">
    <div class="pos-sidebar no-print">
        <button class="cat-btn active" onclick="filterCategory('all', this)">
            <i class="bi bi-grid-fill"></i> الكل
        </button>
        @foreach($categories as $cat)
        <button class="cat-btn" onclick="filterCategory('{{ $cat->id }}', this)">
            <i class="bi bi-tag-fill"></i> {{ $cat->name }}
        </button>
        @endforeach
    </div>

    <div class="pos-content no-print">
        <div class="products-grid" id="grid">
            @foreach($products as $p)
            <div class="p-card item-element" data-category="{{ $p->category_id }}" data-name="{{ $p->name }}" onclick="addToCart('{{$p->id}}', '{{$p->name}}', {{$p->price}})">
                <div class="p-badge d-none text-white" id="badge-{{$p->id}}">0</div>
                <span class="p-name text-white">{{ $p->name }}</span>
                <span class="p-price  text-white ">{{ number_format($p->price, 2) }} <small>ج</small></span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="pos-receipt no-print">
        <div class="receipt-header">
            <select id="table_id" class="form-select border-2 fw-bold text-primary">
                <option value="">طلب تيك أواي بدون طاولة</option>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}">طاولة رقم {{ $table->number }}</option>
                @endforeach
            </select>
        </div>

        <div class="receipt-body" id="cartItems">
            <div class="text-center mt-5 text-muted">
                <i class="bi bi-cart-x display-4 opacity-25"></i>
                <p>السلة فارغة</p>
            </div>
        </div>

        <div class="receipt-footer">
            <div class="total-box">
                <small>الإجمالي:</small>
                <span><span id="grandTotal">0.00</span> <small>ج</small></span>
            </div>

            <div class="paid-input-group">
                <div class="row g-2 align-items-center">
                    <div class="col-6">
                        <label class="small fw-bold text-muted">المدفوع:</label>
                        <input type="number" id="paidInput" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-6 text-start">
                        <label class="small fw-bold text-muted">الباقي:</label>
                        <div id="changeAmount" class="fw-bold text-primary fs-4">0.00</div>
                    </div>
                </div>
            </div>

            <div class="cart-actions-container">
                <button onclick="resetCart()" class="btn-action btn btn-danger" title="مسح السلة">
                    <i class="bi bi-trash3-fill"></i> مسح
                </button>

                <button id="confirmBtn" disabled onclick="submitOrder()" class="btn-action btn-confirm-main">
                    <span>تأكيد الطلب</span>
                    <span class="shortcut-badge">F8</span>
                </button>

                <button onclick="preparePrint()" class="btn-action btn btn-secondary" title="طباعة فاتورة">
                    <i class="bi bi-printer-fill"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<form id="hiddenOrderForm" action="{{ route('orders.cashier.store') }}" method="POST" style="display:none">
    @csrf
    <div id="hiddenInputs"></div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let cart = [];

    // تحديث الساعة
    function updateTime() {
        const now = new Date();
        document.getElementById('liveClock').innerText = now.toLocaleString('ar-EG');
    }
    setInterval(updateTime, 1000); 
    updateTime();

    // بحث المنتجات
    document.getElementById('productSearch').addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.item-element').forEach(el => {
            el.classList.toggle('d-none', !el.dataset.name.toLowerCase().includes(query));
        });
    });

    // فلترة الأقسام
    function filterCategory(catId, btn) {
        document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.item-element').forEach(el => {
            el.classList.toggle('d-none', catId !== 'all' && el.dataset.category !== catId);
        });
    }

    // إضافة منتج للسلة
    function addToCart(id, name, price) {
        let item = cart.find(i => i.id === id);
        if (item) item.qty++; 
        else cart.push({ id, name, price, qty: 1 });
        renderCart();
    }

    // تحديث الكمية
    function updateQty(index, delta) {
        cart[index].qty += delta;
        if (cart[index].qty <= 0) cart.splice(index, 1);
        renderCart();
    }

    // حذف منتج مباشر
   
    // حذف منتج مباشر بدون أي تنبيه
function removeItem(index) {
    cart.splice(index, 1); // حذف المنتج مباشرة
    renderCart(); // تحديث السلة
}


    // عرض السلة
    function renderCart() {
        const container = document.getElementById('cartItems');
        const grandTotalDisplay = document.getElementById('grandTotal');
        const confirmBtn = document.getElementById('confirmBtn');
        const paidInput = document.getElementById('paidInput');

        if(cart.length === 0) {
            container.innerHTML = `<div class="text-center mt-5 text-muted"><i class="bi bi-cart-x display-4 opacity-25"></i><p>السلة فارغة</p></div>`;
            grandTotalDisplay.innerText = "0.00";
            paidInput.value = "";
            confirmBtn.disabled = true;
            document.querySelectorAll('.p-badge').forEach(b => b.classList.add('d-none'));
            calculateChange();
            return;
        }

        let total = 0;
        container.innerHTML = '';
        document.querySelectorAll('.p-badge').forEach(b => b.classList.add('d-none'));

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.qty;
            total += itemTotal;
            const badge = document.getElementById(`badge-${item.id}`);
            if(badge) { badge.innerText = item.qty; badge.classList.remove('d-none'); }

            container.innerHTML += `
                <div class="item-row">
                    <div class="item-info">
                        <span class="item-name">${item.name}</span>
                        <span class="item-price-unit">${item.price.toFixed(2)} ج.م</span>
                    </div>
                    <div class="qty-ctrl">
                        <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
                        <span class="fw-bold">${item.qty}</span>
                        <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
                    </div>
                    <div class="item-total">${itemTotal.toFixed(2)}</div>
                    <button onclick="removeItem(${index})" class="btn-remove-item">×</button>
                </div>
            `;
        });

        grandTotalDisplay.innerText = total.toFixed(2);
        confirmBtn.disabled = false;
        paidInput.value = total.toFixed(2);
        calculateChange();
    }

    // حساب الباقي
    function calculateChange() {
        const total = parseFloat(document.getElementById('grandTotal').innerText) || 0;
        const paid = parseFloat(document.getElementById('paidInput').value) || 0;
        document.getElementById('changeAmount').innerText = Math.max(0, paid - total).toFixed(2);
    }

    document.getElementById('paidInput').addEventListener('input', calculateChange);
    document.getElementById('paidInput').addEventListener('focus', function() { this.select(); });

    // طباعة
    function preparePrint() {
        if(cart.length === 0) return;
        const printBody = document.getElementById('printBody');
        printBody.innerHTML = '';
        cart.forEach(item => {
            printBody.innerHTML += `<tr><td>${item.name}</td><td style="text-align:center">${item.qty}</td><td style="text-align:left">${(item.price*item.qty).toFixed(2)}</td></tr>`;
        });
        document.getElementById('printTotal').innerText = document.getElementById('grandTotal').innerText + " ج.م";
        document.getElementById('printPaid').innerText = (parseFloat(document.getElementById('paidInput').value) || 0).toFixed(2) + " ج.م";
        document.getElementById('printChange').innerText = document.getElementById('changeAmount').innerText + " ج.م";
        document.getElementById('printDate').innerText = new Date().toLocaleString('ar-EG');

        const tableSel = document.getElementById('table_id');
        document.getElementById('printTableInfo').innerText = tableSel.value ? tableSel.options[tableSel.selectedIndex].text : "نوع الطلب: تيك أواي";

        window.print();
    }

    // حفظ الطلب
    function submitOrder() {
        const total = parseFloat(document.getElementById('grandTotal').innerText);
        const paid = parseFloat(document.getElementById('paidInput').value) || 0;
        if(paid < total) { Swal.fire('خطأ','المبلغ المدفوع أقل من الإجمالي!','error'); return; }

        Swal.fire({
            title: 'حفظ الطلب والطباعة؟',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            confirmButtonText: 'حفظ وطباعة',
            cancelButtonText: 'تراجع'
        }).then((result) => {
            if(result.isConfirmed) {
                preparePrint();
                const hiddenInputs = document.getElementById('hiddenInputs');
                hiddenInputs.innerHTML = `<input type="hidden" name="table_id" value="${document.getElementById('table_id').value}">`;
                hiddenInputs.innerHTML += `<input type="hidden" name="total_amount" value="${total}">`;
                hiddenInputs.innerHTML += `<input type="hidden" name="paid_amount" value="${paid}">`;

                cart.forEach((item, i) => {
                    hiddenInputs.innerHTML += `
                        <input type="hidden" name="items[${i}][product_id]" value="${item.id}">
                        <input type="hidden" name="items[${i}][quantity]" value="${item.qty}">
                        <input type="hidden" name="items[${i}][price]" value="${item.price}">
                    `;
                });
                document.getElementById('hiddenOrderForm').submit();
            }
        });
    }

    // مسح السلة
    function resetCart() {
        if(cart.length === 0) return;
        Swal.fire({
            title: 'مسح السلة؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم'
        }).then(r => { if(r.isConfirmed) { cart = []; renderCart(); } });
    }

    // اختصارات الكيبورد
    window.addEventListener('keydown', (e) => {
        if(e.key === 'F2') { e.preventDefault(); document.getElementById('productSearch').focus(); }
        if(e.key === 'F8') { e.preventDefault(); if(!document.getElementById('confirmBtn').disabled) submitOrder(); }
    });

    </script>
     </body> 
    </html>