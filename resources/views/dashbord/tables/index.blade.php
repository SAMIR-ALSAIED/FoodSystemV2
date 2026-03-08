@extends('dashbord.layouts.master')

@section('title', 'الطاولات')

@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الطاولات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                        <li class="breadcrumb-item active">الطاولات</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- زر إضافة طاولة -->
            <div class="d-flex justify-content-between mb-3">
                @can('اضافة طاولات')
                <a href="{{ route('tables.create') }}" class="btn btn-dark">
                    <i class="fas fa-plus"></i> إضافة طاولة
                </a>
                @endcan
                <form action="{{ route('tables.index') }}" method="GET" class="d-flex shadow-sm">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="بحث برقم الطاولة أو الحالة..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('tables.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>
            </div>

            <!-- عرض الطاولات -->
            @include('dashbord.partials.alerts')
            <div class="row">
                @foreach($tables as $table)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <!-- Header مع حالة الطاولة -->
                        <div class="card-header
                            {{ $table->status == 'متاحة' ? 'bg-success text-dark' : ($table->status == 'مشغولة' ? 'bg-danger text-white' : 'bg-warning text-dark') }} text-center">
                            <h5 dir="rtl" class="mb-0">طاولة :{{ $table->number }}</h5>
                        </div>

                        <!-- محتوى الكارد -->
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <div>
                                <p dir="rtl" class="mb-2">الأشخاص: {{ $table->min_guests }} - {{ $table->max_guests }}</p>
                                <p class="mb-3">الحالة: <span class="fw-bold">{{ $table->status }}</span></p>
                            </div>

                            <!-- الأزرار -->
                            <div class="d-flex gap-2 justify-content-center">
                                @can('تعديل طاولات')
                                <a href="{{ route('tables.edit', $table->id) }}" class="btn btn-sm btn-primary flex-fill">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                @endcan

                                <form action="{{ route('tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الطاولة؟')" class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    @can('حذف طاولات')
                                    <button type="submit" class="btn btn-sm btn-danger w-100">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                    @endcan
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex   justify-content-center">
                {{ $tables->links('pagination::bootstrap-4') }}
            </div> 

        </div>
    </section>
</div>



@endsection
