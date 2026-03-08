@extends('dashbord.layouts.master')

@section('title', 'الحجوزات')

@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الحجوزات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                        <li class="breadcrumb-item active">الحجوزات</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">


                        @include('dashbord.partials.alerts')

                        <div class="card-body">


                             <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- زر إضافة منتج -->

        @can( 'اضافة حجوزات')


        <a href="{{ route('reservations.create') }}" class="btn btn-dark d-inline p-2 me-2">
             <i class="fas fa-plus"></i> إضافة حجز جديد
        </a>

              @endcan
        <!-- زر Excel -->
    <span id="exportBtnContainer"></span>

    </div>


                            <table   id="example1" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم العميل</th>
                                        <th>رقم الهاتف</th>
                                        <th>عدد الأشخاص</th>
                                        <th>الطاولة</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الحجز</th>
                                        <th>العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $reservation->customer_name }}</td>
                                        <td>{{ $reservation->phone }}</td>
                                        <td>{{ $reservation->guest_count }}</td>
                                        <td>{{ $reservation->table->number ?? '-' }}</td>

<td>
    <span class="badge {{ $reservation->statusBadge['badge'] }} text-white  px-3 py-2 rounded-3">
        {{ $reservation->statusBadge['text'] }}
    </span>
</td>


<td>{{ \Carbon\Carbon::now('Africa/Cairo')->format('Y-m-d h:i A') }}</td>





                                        <td class="d-flex justify-content-center align-items-center gap-2">

                                                @can( 'تعديل حجوزات')



                                            <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                             @endcan
                                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                @can('حذف حجوزات')


                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                     @endcan
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
