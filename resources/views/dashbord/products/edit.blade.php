@extends('dashbord.layouts.master')

@section('title')
    المنتجات
@endsection

@section('admin_content')

  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>تعديل منتج  </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                 <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
              <li class="breadcrumb-item active">لوحة التحكم</li>
            </ol>
          </div>
        </div>
      </div>
    </section>


    <section class="content">
      <div class="container-fluid">



        <div class="card card-default">


          <form action="{{route('products.update',$product->id)}}" method="POST" enctype="multipart/form-data">

            @csrf

            @method('PUT')

          <div class="card-body">
            <div class="row">


              <div class="col-12">
                <div class="form-group">
                  <label>اسم المنتج</label>

                  <input type="text" class=" form-control" name="name" value="{{$product->name}}">

                  @error('name')
    <small class="text-danger mt-3">{{ $message }}</small>
@enderror
                  </select>
                </div>

              </div>
              <div class="col-12">


              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>سعر المنتج</label>

                  <input type="number" class=" form-control" name="price"   value="{{$product->price}}">
                 @error('price')
    <small class="text-danger mt-3">{{ $message }}</small>
@enderror
                  </select>
                </div>

              </div>



<div class="col-12">
    <div class="form-group">
        <label>القسم</label>
        <select name="category_id" class="form-control select2bs4" style="width: 100%;">
            <option value="">اختر القسم</option>
            @foreach($categories as $category)
 <option value="{{ $category->id }}"
    {{ $product->category_id == $category->id ? 'selected' : '' }}>
    {{ $category->name }}
</option>


            @endforeach
        </select>
        @error('category_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>



                  <div class="col-12">
                <div class="form-group">
                  <label> الصورة</label>

                  <input type="file" class=" form-control mb-3" name="image">
<img src="{{ asset('images/' . $product->image) }}" width="120" height="120">

               @error('image')
    <small class="text-danger mt-3">{{ $message }}</small>
@enderror
                  </select>
                </div>

              </div>
                <button type="submit" class=" btn btn-primary  fw-bold mt-3"> <i class="fas fa-save me-1"></i>تعديل المنتج </button>


          </div>

          </form>

        </div>


        </div>



      </div>
@endsection
