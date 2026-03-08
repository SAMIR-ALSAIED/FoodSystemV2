@extends('dashbord.layouts.master')

@section('title')
    إضافة حجز جديد
@endsection

@section('admin_content')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header" dir="rtl">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h4 class="mt-2">إضافة حجز جديد</h4>
                </div>
                <div class="col-sm-6 text-left">
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left ml-1"></i> رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf

                    <div class="card-body">

                        <!-- Customer Name -->
                        <div class="form-group mb-3">
                            <label for="customer_name" class="font-weight-bold">اسم العميل</label>
                            <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="أدخل اسم العميل">
                            @error('customer_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-group mb-3">
                            <label for="phone" class="font-weight-bold">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="أدخل رقم الهاتف">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Guest Count -->
                        <div class="form-group mb-3">
                            <label for="guest_count" class="font-weight-bold">عدد الأشخاص</label>
                            <input type="number" name="guest_count" class="form-control" value="{{ old('guest_count') }}" min="1">
                            @error('guest_count')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <!-- Reservation Date & Time -->
<div class="form-group mb-3">
    <label for="datetime" class="font-weight-bold">تاريخ ووقت الحجز</label>
    <input
        type="datetime-local"
        name="datetime"
        class="form-control"
        value="{{ old('datetime') }}"
    >

    @error('datetime')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>






                        <!-- Table Selection -->
                        <div class="form-group mb-3">
                            <label for="table_id" class="font-weight-bold">الطاولة</label>
                            <select name="table_id" class="form-select">
                                <option value="">اختر الطاولة</option>
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                        {{ $table->number }} ({{ $table->min_guests }} - {{ $table->max_guests }} أشخاص)
                                    </option>
                                @endforeach
                            </select>
                            @error('table_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group mb-3">
                            <label for="status" class="font-weight-bold">حالة الحجز</label>
                            <select name="status" class="form-select">
                                <option value="في الانتظار" {{ old('status') == 'في الانتظار' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="تم الحجز" {{ old('status') == 'تم الحجز' ? 'selected' : '' }}>تم الحجز</option>
                                <option value="اكتمل الطلب" {{ old('status') == 'اكتمل الطلب' ? 'selected' : '' }}>اكتمل الطلب</option>
                                <option value="ملغي" {{ old('status') == 'ملغي' ? 'selected' : '' }}>ملغي</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-start mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> إضافة الحجز
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </section>

</div>

@endsection
