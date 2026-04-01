@extends('front.layout.app')

@section('title','احجز طاولتك')

@section('front_content')

<section class="page-header position-relative bg-dark py-5" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('front/imges/re.jpg') }}') center/cover;">
    <div class="container text-center py-4">
        <h1 class="text-white display-4 fw-bold mb-2">حجز طاولة</h1>
    </div>
</section>

<section class="reservation py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg p-4 p-md-5 rounded-4">
                    
                    @if(session('success'))
                        <div id="alert-message" class="alert alert-success border-0 shadow-sm mb-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif


                    @if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
    </div>
@endif

                    <form action="{{ route('front.reservation.store') }}" method="POST" class="row g-4">
                        @csrf

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-user text-warning me-1"></i> الاسم بالكامل</label>
                            <input type="text" class="form-control form-control-lg @error('customer_name') is-invalid @enderror" 
                                   name="customer_name" placeholder="مثال: محمد أحمد" value="{{ old('customer_name') }}">
                            @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-phone text-warning me-1"></i> رقم الهاتف</label>
                            <input type="text" class="form-control form-control-lg @error('customer_phone') is-invalid @enderror" 
                                   name="customer_phone" placeholder="01xxxxxxxxx" value="{{ old('customer_phone') }}">
                            @error('customer_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                   <div class="col-md-4">
    <label class="form-label fw-bold">
        <i class="fas fa-calendar-alt text-warning me-1"></i> تاريخ الحجز
    </label>
    <input type="date" 
           class="form-control form-control-lg @error('reservation_date') is-invalid @enderror" 
           name="reservation_date" 
           value="{{ old('reservation_date', date('Y-m-d')) }}" 
           min="{{ date('Y-m-d') }}"> @error('reservation_date') 
        <div class="invalid-feedback">{{ $message }}</div> 
    @enderror
</div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold"><i class="fas fa-clock text-warning me-1"></i> الوقت</label>
                            <input type="time" class="form-control form-control-lg @error('reservation_time') is-invalid @enderror" 
                                   name="reservation_time" value="{{ old('reservation_time') }}">
                            @error('reservation_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold"><i class="fas fa-users text-warning me-1"></i> عدد الأفراد</label>
                            <input type="number" class="form-control form-control-lg @error('guest_count') is-invalid @enderror" 
                                   name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="20">
                            @error('guest_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-warning btn-lg w-100 py-3 fw-bold shadow-sm rounded-3">
                                <i class="fas fa-utensils me-2"></i> تأكيد الحجز الآن
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* تحسينات إضافية CSS */
    .form-control {
        border: 2px solid #eee;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #ffc107;
        box-shadow: none;
        background-color: #fff;
    }
    .rounded-4 { border-radius: 1.5rem !important; }
    .btn-warning {
        background-color: #ffc107;
        border: none;
        transition: transform 0.2s;
    }
    .btn-warning:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
    }
</style>

<script>
    // إخفاء الرسالة بنعومة
    setTimeout(() => {
        const alert = document.getElementById('alert-message');
        if (alert) {
            alert.style.transition = 'opacity 0.8s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 800);
        }
    }, 4000);
</script>

@endsection