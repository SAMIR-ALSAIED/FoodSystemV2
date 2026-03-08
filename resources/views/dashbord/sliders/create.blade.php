@extends('dashbord.layouts.master')

@section('title')
    اضافة سليدر
@endsection
@section('admin_content')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header" dir="rtl">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h4 class="mt-2"> إضافة سليدر   </h4>
                </div>

                <div class="col-sm-6 text-left">
                    <a href="{{ route('sliders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left ml-1"></i> رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="content" >
        <div class="container-fluid">

            <div class="card ">



                <form action="{{ route('sliders.index') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <!-- Name Field -->
                        <div class="form-group">

                            <label for="name" class="font-weight-bold"> العنوان الرئيسي  </label>
                            <input type="text"
                                   name="big_title"
                                   class="form-control"
                                   placeholder="  "
                                   value="{{ old('big_title') }}"
                                 >

                            @error('big_title')
    <small class="text-danger mt-3">{{ $message }}</small>
@enderror

                    </div>



                                 <div class="form-group">

                            <label for="name" class="font-weight-bold"> العنوان الفرعى  </label>
                            <input type="text"
                                   name="small_title"
                                   class="form-control"
                                   placeholder="  "
                                   value="{{ old('small_title') }}"
                                 >

                            @error('small_title')
    <small class="text-danger mt-3">{{ $message }}</small>
@enderror

                    </div>




                                 <div class="form-group">
                                <label> الصورة</label>

                  <input type="file" class=" form-control" name="image" id="previewImage">
                  @error('image')
    <small class="text-danger mt-3">{{ $message }}</small>
@enderror

</div>



















                    <!-- Submit Button -->
                    <div class=" text-left">
                                     <button type="submit" class=" btn btn-primary form-control  fw-bold mt-3">اضافة  </button>

                    </div>

                </form>

            </div>

        </div>
    </section>

</div>

@endsection
