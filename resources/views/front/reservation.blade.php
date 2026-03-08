@extends('front.layout.app')

@section('title','احجز طاولتك')

@section('front_content')



<section class="page-header bg-dark py-5">
    <div class="container text-center">
        <h1 class="text-white display-5 fw-bold">احجز طاولتك الآن</h1>
        <p class="text-white lead">اختر التاريخ والوقت والطاولة المناسبة لك</p>
    </div>
</section>

<section class="reservation py-5 bg-light">
    <div class="container" style="max-width: 900px;">



        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif


       <form action="{{ route('front.reservation.store') }}" method="POST" class="row g-3">
    @csrf

    <div class="col-md-6">
        <label for="customer_name" class="form-label">الاسم</label>
        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
        @error('customer_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="customer_phone" class="form-label">رقم الهاتف</label>
        <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
        @error('customer_phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="reservation_date" class="form-label">التاريخ</label>
        <input type="date" class="form-control" id="reservation_date" name="reservation_date" value="{{ old('reservation_date') }}">
        @error('reservation_date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="reservation_time" class="form-label">الوقت</label>
        <input type="time" class="form-control" id="reservation_time" name="reservation_time" value="{{ old('reservation_time') }}">
        @error('reservation_time')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="guest_count" class="form-label">عدد الضيوف</label>
        <input type="number" class="form-control" id="guest_count" name="guest_count" value="{{ old('guest_count') }}" min="1">
        @error('guest_count')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

<div class="col-md-6">
    <label for="table_id" class="form-label">اختر الطاولة</label>
    <select class="form-select" id="table_id" name="table_id">
        <option value="">اختر الطاولة</option>
        @foreach($tables as $table)
            <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                {{ $table->number }} ({{ $table->min_guests }} - {{ $table->max_guests }} أشخاص)
            </option>
        @endforeach
    </select>
    @error('table_id')
        <span class="text-danger mt-1 d-block">{{ $message }}</span>
    @enderror
</div>



    <div class="col-12 text-center mt-3">
        <button type="submit" class="btn btn-primary btn-lg">
            احجز الآن
        </button>
    </div>
</form>

    </div>
</section>

@endsection
