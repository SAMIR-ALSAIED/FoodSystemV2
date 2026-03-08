@extends('dashbord.layouts.master')

@section('title', 'شاشة المطبخ')

@section('admin_content')
<div class="content-wrapper p-3">
    <section class="content-header mb-3">
        <h1 class="text-center">طلبات المطبخ</h1>
    </section>

    <section class="content">
        <div class="row" id="orders-container">
            @foreach($orders as $order)
                <div class="col-md-4 mb-3 order-card" data-id="{{ $order->id }}">
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <span>طلب #{{ $order->id }}</span>
                            <span>طاولة: {{ $order->table->number ?? 'بدون طاولة' }}</span>
                        </div>
                        <div class="card-body">
                            <p><strong>الكاشير:</strong> {{ $order->user->name ?? '-' }}</p>
                            <p><strong>التاريخ:</strong>  {{ $order->created_at->setTimezone('Africa/Cairo')->format('d/m/Y ') }}</p>
                            <ul class="list-group list-group-flush">
                                @foreach($order->items as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $item->product->name ?? 'منتج محذوف' }}
                                        <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <select class="form-select form-select-sm update-status">
                                <option value="pending" {{ $order->status=='pending'?'selected':'' }}>قيد الانتظار</option>
                                <option value="preparing" {{ $order->status=='preparing'?'selected':'' }}>جار التحضير</option>
                                <option value="completed" {{ $order->status=='completed'?'selected':'' }}>مكتمل</option>
                            </select>
                            <span class="badge {{ $order->status=='pending'?'bg-warning':
                                ($order->status=='preparing'?'bg-info':
                                ($order->status=='ready'?'bg-success':'bg-secondary')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
<script>
document.querySelectorAll('.update-status').forEach(select => {
    select.addEventListener('change', function() {
        const card = this.closest('.order-card');
        const orderId = card.dataset.id;
        const status = this.value;

        fetch(`/dashbord/orders/${orderId}/updateStatus`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status: status })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                const badge = card.querySelector('.card-footer .badge');

                badge.innerText = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                badge.className = 'badge ' + (
                    data.status === 'pending' ? 'bg-warning' :
                    data.status === 'preparing' ? 'bg-info' :
                    data.status === 'ready' ? 'bg-success' :
                    'bg-secondary'
                );

                // ✅ اخفاء الطلب بعد 1 ثانية لو الحالة مكتمل
                if (data.status === 'completed') {
                    setTimeout(() => {
                        card.style.transition = 'opacity 0.5s ease';
                        card.style.opacity = '0';

                        setTimeout(() => {
                            card.remove();
                        }, 500);
                    }, 1000);
                }

            } else {
                alert('حدث خطأ، لم يتم تحديث الحالة');
            }
        })
        .catch(err => {
            console.error(err);
            alert('حدث خطأ، لم يتم تحديث الحالة');
        });
    });
});
</script>

@endsection
