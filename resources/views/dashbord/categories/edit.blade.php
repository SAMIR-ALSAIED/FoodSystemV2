@extends('dashbord.layouts.master')
@section('title')
    تعديل قسم
@endsection
@section('admin_content')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header" dir="rtl">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h4 class="mt-2"><i class="fas fa-layer-group"></i> تعديل قسم   </h4>
                </div>

                <div class="col-sm-6 text-left">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left ml-1"></i> رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card ">



                <form action="{{route('categories.update', $category->id)}}" method="POST">
                    @csrf

                    @method('PUT')
                    <div class="card-body">


                        <div class="form-group">

                            <label for="name" class="font-weight-bold">اسم القسم</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="أدخل اسم القسم"
                                   value="{{$category->name}}"
                                 >

                            @error('name')
    <small class="text-danger mt-3">{{ $message }}</small>
@enderror

                    </div>


                    <div class=" text-left">
                              <button type="submit" class=" btn btn-primary  form-control fw-bold mt-3"> <i class="fas fa-save me-1"></i>تعديل القسم </button>

                    </div>

                </form>

            </div>

        </div>
    </section>

</div>

@endsection
