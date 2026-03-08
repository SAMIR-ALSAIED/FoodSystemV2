@extends('dashbord.layouts.master')

@section('title')
    تعديل الحجز
@endsection

@section('admin_content')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header" dir="rtl">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h4 class="mt-2">تعديل الحجز</h4>
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

                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <!-- Customer Name -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">اسم العميل</label>
                            <input type="text" name="customer_name" class="form-control"
                                   value="{{ old('customer_name', $reservation->customer_name) }}">
                            @error('customer_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $reservation->phone) }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Guest Count -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">عدد الأشخاص</label>
                            <input type="number" name="guest_count" class="form-control" min="1"
                                   value="{{ old('guest_count', $reservation->guest_count) }}">
                            @error('guest_count')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


<div class="form-group mb-3">
    <label class="font-weight-bold">تاريخ ووقت الحجز</label>
    <input type="datetime-local" name="datetime" class="form-control"
       value="{{ old('datetime', \Carbon\Carbon::parse($reservation->datetime)->format('Y-m-d\TH:i')) }}">
    @error('datetime')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>





                        <!-- Table -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">الطاولة</label>
                            <select name="table_id" class="form-select">
                                <option value="">اختر الطاولة</option>
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}"
                                        {{ old('table_id', $reservation->table_id) == $table->id ? 'selected' : '' }}>
                                        {{ $table->number }} ({{ $table->min_guests }} - {{ $table->max_guests }})
                                    </option>
                                @endforeach
                            </select>
                            @error('table_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Status -->
                      <div class="form-group mb-3">
    <label class="font-weight-bold">حالة الحجز</label>
    <select name="status" class="form-select">
        <option value="في الانتظار" {{ old('status', $reservation->status) == 'في الانتظار' ? 'selected' : '' }}>في الانتظار</option>
        <option value="تم الحجز"    {{ old('status', $reservation->status) == 'تم الحجز' ? 'selected' : '' }}>تم الحجز</option>
        <option value="اكتمل الطلب" {{ old('status', $reservation->status) == 'اكتمل الطلب' ? 'selected' : '' }}>اكتمل الطلب</option>
        <option value="ملغي"        {{ old('status', $reservation->status) == 'ملغي' ? 'selected' : '' }}>ملغي</option>
    </select>
    @error('status')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                        <!-- Submit -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> حفظ التعديلات
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </section>

</div>

@endsection
