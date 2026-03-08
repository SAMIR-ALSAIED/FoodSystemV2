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
            <h1>اضافة منتج جديد </h1>
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


          <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">

            @csrf

          <div class="card-body">
            <div class="row">


              <div class="col-12">
                <div class="form-group">
                  <label>اسم المنتج</label>

                  <input type="text" class=" form-control" name="name">

                            @error('name')
    <small class="text-danger mt-3">{{ $message }}</small>
@enderror

                  </select>
                </div>

              </div>

              <div class="col-12">
                <div class="form-group">
                  <label>سعر المنتج</label>

                  <input type="number" class=" form-control" name="price">
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
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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

                  <input type="file" class=" form-control" name="image" id="previewImage">
                  @error('image')
    <small class="text-danger mt-3">{{ $message }}</small>
@enderror

                </div>

              </div>

   <div class="mt-2">
      <img id="imagePreview" src="" alt=" " class="img-fluid rounded border" width="130" height="130" >
    </div>


                </div>

                <button type="submit" class=" btn btn-primary fw-bold mt-3 form-control ">اضافة  المنتج </button>

              </div>

            </div>

          </div>

          </form>

        </div>


        </div>



      </div>


<script>
  document.getElementById('previewImage').addEventListener('change', function(e){
      const [file] = e.target.files;
      const preview = document.getElementById('imagePreview');

      if(file){
          preview.src = URL.createObjectURL(file); // رابط مؤقت للمعاينة
          preview.style.display = 'block'; // إظهار الصورة
      } else {
          preview.src = "#";
          preview.style.display = 'none'; // إخفاء الصورة إذا لم يتم اختيار أي ملف
      }
  });
</script>

@endsection
