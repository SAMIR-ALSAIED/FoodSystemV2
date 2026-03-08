<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
  شاشة الكاشير
    </title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    
  <link rel="stylesheet" href="{{asset('admin')}}/dist/css/cashier.css">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

       
</head>
<body>

<header class="no-print">
    <div class="d-flex align-items-center gap-4">
        <h4 class="m-0 fw-bold text-white d-flex align-items-center gap-2">
            <i class="bi bi-lightning-charge-fill text-warning"></i> 
            شاشة الكاشير
        </h4>

        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="mainSearch" class="form-control text-white" placeholder="بحث عن منتج...">
        </div>
    </div>

    <div class="d-flex align-items-center gap-4">

        <!-- الساعة -->
<div class="clock-box d-flex align-items-center gap-2 px-3 py-1">
    <i class="bi bi-clock-fill text-warning"></i>
    <span id="clock" class="fw-bold"></span>
</div>

        <!-- المستخدم -->
        <div class="user-box d-flex align-items-center gap-2 px-3 py-1">
            <i class="bi bi-person-circle fs-5 text-warning"></i>
            <span class="fw-bold text-white">
                {{ auth()->user()->name }}
            </span>
        </div>

        <!-- زر تسجيل الخروج -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-outline-danger d-flex align-items-center gap-2 px-3">
                <i class="bi bi-box-arrow-right"></i>
                خروج
            </button>
        </form>

    </div>
</header>


<div class="container-fluid no-print">
    <div class="row">
        <div class="col-md-1 p-0">
            <div class="category-sidebar">
                <button class="cat-item active" onclick="filterCat('', this)"> الكل</button>
                @foreach($categories as $cat)
                    <button class="cat-item" onclick="filterCat('{{ $cat->id }}', this)">{{ $cat->name }}</button>
                @endforeach
            </div>
        </div>

        <div class="col-md-7 p-0">
            <div class="main-content">
                <div class="row g-3" id="productsGrid">
                    @foreach($products as $p)
                    <div class="col-4 col-lg-3 col-xl-2 product-wrapper" data-cat="{{ $p->category_id }}" data-name="{{ $p->name }}">
                        <div class="product-card" onclick="addToCart('{{$p->id}}', '{{$p->name}}', {{$p->price}})">
                            <div class="badge-qty d-none" id="qty-{{$p->id}}">0</div>
                            <span class="p-2 fw-bold small mb-4">{{ $p->name }}</span>
                            <div class="price-tag">{{ number_format($p->price) }} <small>ج</small></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4 p-0">
            <div class="order-panel mt-2 shadow-lg">
                <div class="total-area">
                    <small class="opacity-75">المبلغ الإجمالي</small>
                    <h1 class="m-0 fw-bold"><span id="grandTotal">0</span> <small class="fs-6">ج</small></h1>
                </div>

                <div class="p-2 bg-light border-bottom">
                    <select id="tableSelect" class="form-select border-0 fw-bold text-primary">
                        <option value=""> طلب بدون طاولة (Takeaway)</option>
                        @foreach($tables as $t)
                            <option value="{{ $t->id }}"> طاولة رقم {{ $t->number }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="bill-list">
                    <table class="table table-sm receipt-table align-middle text-center" id="billTable">
                        <thead>
                            <tr>
                                <th class="text-start">الصنف</th>
                                <th width="120">الكمية</th>
                                <th>الإجمالي</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="p-3 bg-white border-top shadow-lg">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="small fw-bold text-muted d-block text-center mb-1">المدفوع</label>
                            <input type="number" id="inputPaid" class="form-control form-control-lg text-center fw-bold text-success border-2">
                        </div>
                        <div class="col-6 border-start text-center">
                            <label class="small fw-bold text-muted d-block mb-1">الباقي</label>
                            <h3 id="displayChange" class="m-0 fw-bold text-primary">0.00</h3>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button onclick="processOrder()" class="btn btn-confirm">تأكيد الطلب </button>
                        <div class="row g-2">

                            <div class="col-6">
    <button onclick="printThermal()" 
        class="btn btn-outline-dark w-100 fw-bold border-2 d-flex align-items-center justify-content-center gap-2">
        <i class="bi bi-printer-fill"></i>
        طباعة
    </button>
</div>

<div class="col-6">
    <button onclick="resetCart()" 
        class="btn btn-outline-danger w-100 fw-bold border-2 d-flex align-items-center justify-content-center gap-2">
        <i class="bi bi-trash3-fill"></i>
        مسح الكل
    </button>
</div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
let cart = [];

/* =======================
   التوقيت
======================= */
function updateClock() {
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const date = now.toLocaleDateString('ar-EG', options);
    const time = now.toLocaleTimeString('ar-EG');
    document.getElementById('clock').innerText = `${date} | ${time}`;
}
setInterval(updateClock, 1000);
updateClock();

/* =======================
   البحث + الفلترة
======================= */
document.getElementById('mainSearch').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    document.querySelectorAll('.product-wrapper').forEach(el => {
        el.style.display = el.dataset.name.toLowerCase().includes(query) ? "block" : "none";
    });
});

function filterCat(id, btn) {
    document.querySelectorAll('.cat-item').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.product-wrapper').forEach(el => {
        el.style.display = (id === "" || el.dataset.cat === id) ? "block" : "none";
    });
}

/* =======================
   إدارة السلة
======================= */
function addToCart(id, name, price) {
    let item = cart.find(i => i.id === id);
    if(item) { 
        item.qty++; 
    } else { 
        cart.push({id, name, price, qty: 1}); 
    }
    updateUI();
    Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1000
    }).fire({ icon: 'success', title: 'تمت الإضافة' });
}

function updateUI() {
    const tbody = document.querySelector('#billTable tbody');
    tbody.innerHTML = '';
    let total = 0;

    document.querySelectorAll('.badge-qty').forEach(b => b.classList.add('d-none'));

    cart.forEach((item, index) => {
        total += (item.qty * item.price);

        tbody.innerHTML += `
            <tr>
                <td class="text-start">${item.name}</td>
                <td>
                    <div class="qty-controls">
                        <div class="qty-btn" onclick="changeQty(${index}, -1)">-</div>
                        <span class="fw-bold fs-5">${item.qty}</span>
                        <div class="qty-btn" onclick="changeQty(${index}, 1)">+</div>
                    </div>
                </td>
                <td>${(item.qty * item.price).toFixed(2)}</td>
                <td>
                    <i class="bi bi-trash text-danger" 
                       style="cursor:pointer" 
                       onclick="removeItem(${index})"></i>
                </td>
            </tr>`;

        const badge = document.getElementById(`qty-${item.id}`);
        if(badge) { 
            badge.innerText = item.qty; 
            badge.classList.remove('d-none'); 
        }
    });

    document.getElementById('grandTotal').innerText = total.toFixed(2);

    // تعبئة المدفوع تلقائياً بقيمة الإجمالي
    document.getElementById('inputPaid').value = total.toFixed(2);

    calcChange();
}

function changeQty(index, delta) {
    cart[index].qty += delta;
    if(cart[index].qty < 1) return removeItem(index);
    updateUI();
}

function removeItem(index) {
    cart.splice(index, 1);
    updateUI();
}

/* =======================
   حساب الباقي
======================= */
function calcChange() {
    const total = parseFloat(document.getElementById('grandTotal').innerText) || 0;
    const paid = parseFloat(document.getElementById('inputPaid').value) || 0;

    document.getElementById('displayChange').innerText =
        Math.max(0, paid - total).toFixed(2);
}

document.getElementById('inputPaid').addEventListener('input', calcChange);

/* =======================
   الطباعة
======================= */
function printThermal() {
    if (cart.length === 0)
        return Swal.fire('تنبيه', 'لا يوجد أصناف للطباعة', 'warning');

    const win = window.open('', '_blank');
    let rows = cart.map(i => `
        <tr>
            <td style="text-align:right;">${i.name}</td>
            <td style="text-align:center; font-weight:bold;">${i.qty}</td>
            <td style="text-align:left;">${(i.qty * i.price).toFixed(2)}</td>
        </tr>`).join('');

    win.document.write(`
        <html dir="rtl">
        <head>
            <style>
                body { font-family: Arial; width: 80mm; padding: 10px; margin: 0; }
                .text-center { text-align: center; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                th { border-bottom: 1px dashed #000; padding: 5px; }
                td { padding: 8px 0; font-size: 14px; }
                .total { font-size: 18px; font-weight: bold; border-top: 2px solid #000; margin-top: 10px; padding-top: 10px; }
            </style>
        </head>
        <body onload="window.print(); window.close();">
            <div class="text-center">
                <h2>مطعمنا</h2>
                <p>${new Date().toLocaleString('ar-EG')}</p>
                  <p style="font-size:13px; margin-top:5px;">
       اسم الكاشير: {{ auth()->user()->name }}
    </p>
            </div>
            <hr>
            <table>
                <thead>
                    <tr><th>الصنف</th><th>الكمية</th><th>السعر</th></tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>
            <div class="total text-center">
                الإجمالي: ${document.getElementById('grandTotal').innerText} ج
            </div>
            <p class="text-center">شكراً لزيارتكم</p>
        </body>
        </html>
    `);

    win.document.close();
}

/* =======================
   حفظ الطلب (نسخة احترافية)
======================= */
function processOrder() {

    if(cart.length === 0)
        return Swal.fire('عذراً', 'السلة فارغة!', 'warning');

    const total = parseFloat(document.getElementById('grandTotal').innerText) || 0;
    const paidInput = document.getElementById('inputPaid');
    const paid = parseFloat(paidInput.value);

    if(!paidInput.value || paid <= 0){
        return Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: 'يجب إدخال المبلغ المدفوع'
        });
    }

    if(paid < total){
        return Swal.fire({
            icon: 'error',
            title: 'المبلغ غير كافي',
            text: 'المبلغ المدفوع أقل من قيمة الإجمالي'
        });
    }

    Swal.fire({
        title: 'تأكيد الحفظ؟',
        text: "هل تريد حفظ الطلب في قاعدة البيانات؟",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        confirmButtonText: 'نعم، حفظ',
        cancelButtonText: 'إلغاء'
    }).then((result) => {

        if (result.isConfirmed) {

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('orders.cashier.store') }}";

            let html = `
                <input type="hidden" name="_token"
                    value="${document.querySelector('meta[name=csrf-token]').content}">
                <input type="hidden" name="table_id"
                    value="${document.getElementById('tableSelect').value}">
                <input type="hidden" name="paid_amount" value="${paid}">
                <input type="hidden" name="total_amount" value="${total}">
            `;

            cart.forEach((item, i) => {
                html += `
                    <input type="hidden" name="items[${i}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${i}][quantity]" value="${item.qty}">
                    <input type="hidden" name="items[${i}][price]" value="${item.price}">
                `;
            });

            form.innerHTML = html;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

/* =======================
   مسح السلة
======================= */
function resetCart() {
    Swal.fire({
        title: 'مسح الفاتورة؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم',
        cancelButtonText: 'تراجع'
    }).then((result) => {
        if (result.isConfirmed) {
            cart = [];
            updateUI();
        }
    });
}
</script>


</body>
</html>