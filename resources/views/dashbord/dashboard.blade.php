@extends('dashbord.layouts.master')

@section('title') الرئيسية @endsection

@section('admin_content')

@can('لوحة المسوول')



<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center">
          <div class="col-sm-6">
            {{-- <h class="m-0 text-dark text-shadow" style="text-shadow: 1px 1px 3px #aaa;">لوحة الاحصائيات</h> --}}
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
              <li class="breadcrumb-item active">لوحة التحكم</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Cards الإحصائيات -->
    <div class="row">

        <!-- كارد المنتجات -->
<div class="col-lg-3 col-6">
    <div class="small-box text-white shadow-lg" style="background: linear-gradient(135deg, #1abc9c, #16a085);">
        <div class="inner">
            <h3>{{ $products_count }}</h3>
            <p>المنتجات</p>
        </div>
        <div class="icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
    </div>
</div>

<!-- كارد الأقسام -->
<div class="col-lg-3 col-6">
    <div class="small-box text-white shadow-lg" style="background: linear-gradient(135deg, #3498db, #2980b9);">
        <div class="inner">
            <h3>{{ $category_count }}</h3>
            <p>الأقسام</p>
        </div>
        <div class="icon">
            <i class="fas fa-layer-group"></i>
        </div>
    </div>
</div>

<!-- كارد الطلبات -->
<div class="col-lg-3 col-6">
    <div class="small-box text-white shadow-lg" style="background: linear-gradient(135deg, #e67e22, #d35400);">
        <div class="inner">
            <h3>{{ $orders_count }}</h3>
            <p>الطلبات</p>
        </div>
        <div class="icon">
            <i class="fas fa-receipt"></i>
        </div>
    </div>
</div>

<!-- كارد المستخدمين -->
<div class="col-lg-3 col-6">
    <div class="small-box text-white shadow-lg" style="background: linear-gradient(135deg, #9b59b6, #8e44ad);">
        <div class="inner">
            <h3>{{ $users_count }}</h3>
            <p>المستخدمين</p>
        </div>
        <div class="icon">
            <i class="fas fa-user-friends"></i>
        </div>
    </div>
</div>

    <!-- كارد الأقسام -->

</div>


            <!-- الإيرادات والحجوزات -->
            <div class="row">
                <!-- إيراد اليوم -->
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card shadow-sm rounded-lg border-primary">
                        <div class="card-header bg-primary text-white rounded-top"    style="background: linear-gradient(135deg, #27ae60, #2ecc71); transition: transform 0.3s;">
                            <h3 class="card-title">إيراد اليوم</h3>
                        </div>
                        <div class="card-body text-center">
                            <h2 class="text-success font-weight-bold" style="font-size:2.2rem;">{{ number_format($today_income, 2) }} جنية</h2>
                            <i class="fas fa-coins fa-2x text-dark mt-2"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 mb-3">
    <div class="card shadow-sm rounded-lg border-success">
        <div class="card-header bg-success text-white rounded-top">

            <h3 class="card-title">
    إجمالي المبيعات 
    {{ $month ? 'لشهر '.\Carbon\Carbon::create()->month((int)$month)->format('F') : 'للسنة '.$year }}
</h3>
        </div>
        <div class="card-body text-center">
            <h2 class="text-success  font-weight-bold" style="font-size:2.2rem;">
                {{ number_format($total_sales, 2) }} جنية
            </h2>
            <i class="fas fa-dollar-sign fa-2x text-dark mt-2"></i>
        </div>
    </div>
</div>

            <!-- آخر الحجوزات -->
<div class="col-12 mb-3">
    <div class="card shadow-sm rounded-lg border-info">
        <div class="card-header bg-info text-white rounded-top"      style="background: linear-gradient(135deg, #2980b9, #3498db); transition: transform 0.3s;">
            <h3 class="card-title">آخر الحجوزات</h3>
        </div>
        <div class="card-body table-responsive p-0" style="max-height: 300px;">
            <table class="table table-hover text-nowrap table-bordered mb-0">
                <thead class="thead-dark bg-secondary text-white">
                    <tr>
                        <th>العميل</th>
                        <th>الطاولة</th>
                        <th>التاريخ والوقت</th>
                        <th> حالة الحجز</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latest_reservations as $res)
                    <tr>
                        <td>{{ $res->customer_name }}</td>
                        <td>{{ $res->table->number ?? '-' }}</td>

<td>{{ \Carbon\Carbon::now('Africa/Cairo')->format('Y-m-d h:i A') }}</td>
<td>
    <span class="badge {{ $res->statusBadge['badge'] }} text-white  px-3 py-2 rounded-3">
        {{ $res->statusBadge['text'] }}
    </span>
</td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<form method="GET" class="row mb-4 g-3">
    <div class="col-md-3">
        <label>السنة</label>
        <input type="number" name="year" value="{{ $year }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label>الشهر</label>
        <select name="month" class="form-control">
            @for($m=1;$m<=12;$m++)
                <option value="{{ $m }}" {{ $month==$m?'selected':'' }}>
                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary w-100">عرض</button>
    </div>
</form>


            <!-- Chart -->
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="card shadow-sm rounded-lg border-success">
                        <div class="card-header bg-success text-white rounded-top"   style="background: linear-gradient(135deg, #16a085, #1abc9c); transition: transform 0.3s;">
                            <h3 class="card-title">مبيعات الشهر الحالي</h3>

                        </div>
                        <div class="card-body">
                            <canvas id="salesChart" style="height: 350px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>


<div class="col-lg-12 col-md-12 mb-3 mt-3">

 <div class="card-header bg-info text-white rounded-top"   style="background: linear-gradient(135deg, #8e44ad, #9b59b6); transition: transform 0.3s;">

    <h5 class="mt-4">آخر 10 اوردرات</h5>

 </div>
    @if($latest_orders->count())
        <table class="table table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>رقم الطلب</th>
                    <th>اسم العميل</th>
                    <th>إجمالي المبلغ</th>
                    <th>تاريخ الطلب</th>
                    <th>الحالة</th>
                    <th>
عرض
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($latest_orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'ضيف' }}</td>
                        <td>{{ number_format($order->total, 2) }} ج</td>
                        <td>    {{ $order->created_at->setTimezone('Africa/Cairo')->format('d/m/Y g:i A') }}

                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">قيد الانتظار</span>
                            @elseif($order->status == 'completed')
                                <span class="badge bg-success">مكتمل</span>
                            @elseif($order->status == 'canceled')
                                <span class="badge bg-danger">ملغى</span>
                            @else
                                <span class="badge bg-secondary">غير محدد</span>
                            @endif
                        </td>



                             <td><a class="btn btn-info" href="{{ route('orders.show',$order->id ) }}">عرض </a></td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>لا يوجد طلبات حتى الآن.</p>
    @endif
</div>

        </div>
    </section>
</div>

@endcan
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chart_labels),
        datasets: [{
            label: 'إجمالي المبيعات',
            data: @json($chart_data),
            backgroundColor: 'rgba(0, 123, 255, 0.2)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: 'rgba(0, 123, 255, 1)',
            pointRadius: 5,
            pointHoverRadius:7
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true, position: 'top' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

@endsection
