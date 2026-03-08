@extends('dashbord.layouts.master')

@section('title', 'إدارة طلبات العملاء')

@section('admin_content')
<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fas fa-shopping-basket text-primary"></i> إدارة طلبات العملاء</h1>
    </section>

    <section class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table id="example1" class="table table-hover table-bordered text-center align-middle">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>التواصل</th>
                            <th>العنوان</th>
                            <th>الإجمالي</th>
                            <th>الحالة</th>
                            <th>التاريخ والوقت</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong>{{ $order->id }}</strong></td>
                            <td>{{ $order->name }}</td>
                            <td>
                                <small class="d-block"><i class="fas fa-phone"></i> {{ $order->phone }}</small>
                                <small class="text-muted"><i class="fas fa-envelope"></i> {{ $order->email }}</small>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($order->address, 30) }}</td>
                            <td class="text-primary font-weight-bold">{{ number_format($order->total, 2) }} ج</td>
                            <td>
                                @php
                                    $statuses = [
                                        'pending' => ['label' => 'قيد الانتظار', 'color' => 'warning', 'icon' => 'clock'],
                                        'completed' => ['label' => 'مكتمل', 'color' => 'success', 'icon' => 'check-circle'],
                                    ];
                                    $currentStatus = $statuses[$order->status] ?? ['label' => $order->status, 'color' => 'secondary', 'icon' => 'info-circle'];
                                @endphp
                                <span class="badge bg-{{ $currentStatus['color'] }} p-2">
                                    <i class="fas fa-{{ $currentStatus['icon'] }}"></i> {{ $currentStatus['label'] }}
                                </span>
                            </td>
                            <td>{{ now()->format('Y/m/d') }} | {{ now()->format('h:i A') }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}" title="عرض المنتجات">
                                        <i class="fas fa-eye"></i>
                                    </button>
<form action="{{ route('customer-orders.destroy', $order->id) }}" method="POST"  >
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm me-2 d-inline">
        <i class="fas fa-trash"></i>
    </button>
</form>
                                </div>

                                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light d-flex justify-content-between border-bottom-0">
                                                <h5 class="modal-title">تفاصيل الطلب رقم #{{ $order->id }}</h5>
                                                <button type="button" class="btn-close m-0" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-4">
                                                    <div class="col-md-6 border-left">
                                                        <h6 class="text-muted border-bottom pb-2">بيانات العميل</h6>
                                                        <p class="mb-1"><strong>الاسم:</strong> {{ $order->name }}</p>
                                                        <p class="mb-1"><strong>الهاتف:</strong> {{ $order->phone }}</p>
                                                        <p class="mb-1"><strong>العنوان:</strong> {{ $order->address }}</p>
                                                    </div>
                                                    <div class="col-md-6 text-md-left">
                                                        <h6 class="text-muted border-bottom pb-2">حالة الطلب</h6>
                                                        <span class="badge bg-{{ $currentStatus['color'] }} fs-6">{{ $currentStatus['label'] }}</span>
                                                    </div>
                                                </div>

                                                <table class="table table-sm table-striped border">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>المنتج</th>
                                                            <th>الكمية</th>
                                                            <th>السعر</th>
                                                            <th>الإجمالي</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($order->items as $item)
                                                        <tr>
                                                            <td>{{ $item->product_name }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>{{ number_format($item->price, 2) }}</td>
                                                            <td>{{ number_format($item->total, 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between bg-light">
                                                @if($order->status == 'pending')
                                                    <form action="{{ route('customer-orders.updateStatus', $order->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="btn btn-success px-4 ">
                                                            <i class="fas fa-check"></i> تم التنفيذ (مكتمل)
                                                        </button>
                                                    </form>
                                                @endif
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection