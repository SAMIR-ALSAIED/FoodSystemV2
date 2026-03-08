@extends('dashbord.layouts.master')

@section('title', 'تفاصيل الطلب')


<style>
    <style>
@media print {
    body { 
        background: white; 
        font-family: 'Segoe UI', Tahoma, sans-serif;
        font-size: 12px;
        direction: rtl;
    }

    .no-print { display: none !important; }

    #printArea { 
        display: block !important; 
        width: 80mm; 
        padding: 5mm;
        color: black;
    }

    .print-header, .print-footer {
        text-align: center;
        margin-bottom: 5px;
    }

    .print-header h3 { margin: 0; font-size: 16px; }
    .print-header p { margin: 2px 0; font-size: 12px; }

    .print-table { 
        width: 100%; 
        border-collapse: collapse; 
        margin: 5px 0; 
        font-size: 12px;
    }
    .print-table th, .print-table td {
        padding: 3px 0;
    }
    .print-table th { 
        border-bottom: 1px dashed #000; 
        text-align: right;
        font-weight: bold;
    }
    .print-table td { 
        text-align: right; 
    }

    .print-total {
        border-top: 1px dashed #000; 
        margin-top: 5px; 
        padding-top: 3px;
    }
    .print-total div {
        display: flex; 
        justify-content: space-between;
        font-size: 12px;
    }
    .print-footer {
        margin-top: 10px; 
        font-size: 11px;
        border-top: 1px dashed #000; 
        padding-top: 5px;
    }
}
</style>

@section('admin_content')
<div class="content-wrapper p-3">

    <!-- عنوان الصفحة والعودة -->
    <section class="content-header mb-3 d-flex justify-content-between align-items-center">
        <h1>تفاصيل الطلب #{{ $order->id }}</h1>
        <div>
            <a href="{{ route('orders.index') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left"></i> العودة للطلبات
            </a>
            <button class="btn btn-success" id="print-order-invoice">
                <i class="bi bi-printer"></i> طباعة الفاتورة
            </button>
        </div>
    </section>

    <section class="content">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">معلومات الطلب</h3>
            </div>
            <div class="card-body">

                @php
                    $statuses = [
                        'pending'   => ['label' => 'قيد الانتظار', 'color' => 'warning'],
                        'preparing' => ['label' => 'جار التحضير', 'color' => 'info'],
                        'ready'     => ['label' => 'جاهز', 'color' => 'success'],
                        'completed' => ['label' => 'مكتمل', 'color' => 'secondary'],
                        'canceled'  => ['label' => 'ملغى', 'color' => 'danger'],
                    ];
                @endphp

                <!-- معلومات أساسية -->
                <div class="row mb-4 text-center text-md-start">
                    <div class="col-md-3 mb-2">
                        <p class="mb-0"><strong>الطاولة:</strong> {{ $order->table->number ?? 'بدون طاولة' }}</p>
                    </div>
                    <div class="col-md-3 mb-2">
                        <p class="mb-0"><strong>المستخدم:</strong> {{ $order->user->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-3 mb-2">
                        <p class="mb-0">
                            <strong>الحالة:</strong>
                            <span class="badge rounded-pill px-3 py-2
                                text-dark {{ $statuses[$order->status]['color']=='warning' ? 'bg-warning' : '' }}
                                {{ $statuses[$order->status]['color']=='info' ? 'bg-info text-white' : '' }}
                                {{ $statuses[$order->status]['color']=='success' ? 'bg-success text-white' : '' }}
                                {{ $statuses[$order->status]['color']=='secondary' ? 'bg-secondary text-white' : '' }}
                                {{ $statuses[$order->status]['color']=='danger' ? 'bg-danger text-white' : '' }}">
                                {{ $statuses[$order->status]['label'] ?? ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-3 mb-2">
                        <p class="mb-0"><strong>الإجمالي:</strong> {{ number_format($order->total, 2) }} ج.م</p>
                    </div>
                </div>

                <!-- جدول المنتجات -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>#</th>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->name ?? 'منتج محذوف' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 2) }}</td>
                                    <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- الإجمالي الكلي -->
                <div class="mt-3 text-end">
                    <h5 class="fw-bold">الإجمالي الكلي: {{ number_format($order->total, 2) }} ج.م</h5>
                </div>

            </div>
        </div>
    </section>
</div>

<script>
const order = @json($order);
const cashierName = "{{ auth()->user()->name }}";

document.getElementById('print-order-invoice').addEventListener('click', () => {
    let itemsHtml = '';
    
    order.items.forEach(item => {
        const itemTotal = parseFloat(item.price) * parseInt(item.quantity);
        itemsHtml += `
            <tr>
                <td style="text-align:right;">${item.product ? item.product.name : 'منتج محذوف'}</td>
                <td style="text-align:center;">${item.quantity}</td>
                <td style="text-align:center;">${parseFloat(item.price).toFixed(2)}</td>
                <td style="text-align:left;">${itemTotal.toFixed(2)}</td>
            </tr>
        `;
    });

    const orderDate = new Date(order.created_at);
    const formattedDate = orderDate.toLocaleString('ar-EG', { 
        day: '2-digit', month: '2-digit', year: 'numeric', 
        hour: '2-digit', minute: '2-digit', hour12: true 
    });

    const invoiceHtml = `
<html dir="rtl">
<head>
    <title>فاتورة رقم ${order.id}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');
        
        body { 
            font-family: 'Cairo', sans-serif; 
            margin: 0; 
            padding: 10px; 
            width: 80mm; /* عرض ورق الكاشير */
            color: #000;
        }
        .header { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 12px; }
        
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        
        .info-table { width: 100%; font-size: 12px; margin-bottom: 10px; }
        .info-table td { padding: 2px 0; }

        table.items-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        table.items-table th { 
            border-bottom: 1px solid #000; 
            padding: 5px 0; 
            font-weight: bold;
        }
        table.items-table td { padding: 5px 0; border-bottom: 0.5px solid #eee; }
        
        .totals { margin-top: 10px; width: 100%; }
        .totals td { font-size: 14px; font-weight: bold; padding: 4px 0; }
        .total-row { border-top: 1px double #000; }

        .footer { text-align: center; margin-top: 15px; font-size: 11px; }
        
        @media print {
            @page { margin: 0; }
            body { margin: 5mm; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>  مطعمنا</h2>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>رقم الطلب:</strong> #${order.id}</td>
            <td style="text-align:left;"><strong>الطاولة:</strong> ${order.table ? order.table.number : 'تيك اوى'}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>التاريخ:</strong> ${formattedDate}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>الكاشير:</strong> ${cashierName}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="text-align:right; width:40%">الصنف</th>
                <th style="text-align:center;">ك</th>
                <th style="text-align:center;">سعر</th>
                <th style="text-align:left;">إجمالي</th>
            </tr>
        </thead>
        <tbody>
            ${itemsHtml}
        </tbody>
    </table>

    <table class="totals">
        <tr class="total-row">
            <td style="text-align:right;">الإجمالي :</td>
            <td style="text-align:left;">${parseFloat(order.total).toFixed(2)} ج</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="footer">
        <p>شكراً لزيارتكم!</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() { window.close(); }, 500);
        };
    <\/script>
</body>
</html>
`;

    const printWindow = window.open('', '_blank', 'width=400,height=600');
    printWindow.document.open();
    printWindow.document.write(invoiceHtml);
    printWindow.document.close();
});
</script>
@endsection
