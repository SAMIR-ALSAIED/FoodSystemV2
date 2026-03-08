@extends('dashbord.layouts.master')

@section('title', 'إضافة طاولة')

@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إضافة طاولة جديدة</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('tables.index') }}">الطاولات</a></li>
                        <li class="breadcrumb-item active">إضافة طاولة</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('tables.store') }}" method="POST" >
                        @csrf

                        <!-- رقم الطاولة -->
               <div class="mb-3">
    <label for="number" class="form-label">رقم الطاولة</label>
    <input type="text" name="number" class="form-control" value="{{ old('number') }}" >
    @error('number')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>


                        <!-- الحد الأدنى للضيوف -->
                        <div class="mb-3">
                            <label for="min_guests" class="form-label">الحد الأدنى للضيوف</label>
                            <input type="number" name="min_guests" class="form-control  value="{{ old('min_guests')}}>
                            @error('min_guests')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- الحد الأقصى للضيوف -->
                        <div class="mb-3">
                            <label for="max_guests" class="form-label">الحد الأقصى للضيوف</label>
                            <input type="number" name="max_guests" class="form-control value="{{ old('max_guests') }}" >
                            @error('max_guests')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- الحالة -->
                        <div class="mb-3">
                            <label for="status" class="form-label">الحالة</label>
                            <select name="status" class="form-select ">
                                <option value="" >اختار الحالة</option>
                                <option value="متاحة" {{ old('status') == 'متاحة' ? 'selected' : '' }}>متاحة</option>
                                <option value="مشغولة" {{ old('status') == 'مشغولة' ? 'selected' : '' }}>مشغولة</option>
                                <option value="محجوزة" {{ old('status') == 'محجوزة' ? 'selected' : '' }}>محجوزة</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-start mt-4">
                            <button type="submit" class="btn btn-primary form-control "><i class="fas fa-plus me-1"></i> إضافة</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
