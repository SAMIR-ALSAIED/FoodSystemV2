@extends('dashbord.layouts.master')

@section('title')
    الاقسام
@endsection

@section('admin_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>بيانات الاقسام</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
              <li class="breadcrumb-item active">لوحة التحكم</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <!-- /.card -->

            <div class="card">
               <div class="card-header">
        <div class="row align-items-center">

            <!-- زر إضافة منتج -->


            <!-- فورم البحث -->
     {{-- <div class="col-md-9 d-flex justify-content-end">
    <form action="{{ route('categories.index') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control form-control "
               placeholder="ابحث عن منتج ..." value="{{ request('search') }}" >

        <button class="btn btn-sm btn-info me-1 ">
            <i class="fas fa-search "></i>
        </button>

        @if(request('search'))
            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-dark me-1">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </form>
</div> --}}


        </div>
    </div>
              <!-- /.card-header -->





              <div class="card-body">


 <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- زر إضافة منتج -->
        <a href="{{ route('categories.create') }}" class="btn btn-dark d-inline p-2 me-2">
            <i class="fas fa-plus"></i> إضافة قسم
        </a>

        <!-- زر Excel -->
    <span id="exportBtnContainer"></span>

    </div>





                <table id="example1" class="table table-bordered table-hover text-center">
                  <thead>
        @include('dashbord.partials.alerts')
                  <tr>
                    <th class=" ">#</th>
                    <th class=" ">اسم القسم</th>
                    <th>عدد  المنتجات </th>
                    {{-- <th>  المنتجات المرتبطة </th> --}}
                    <th class=" ">العمليات</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($categories as $category )


                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$category->name}}  </td>
                    <td>{{$category->products->count()}}  </td>
                    {{-- <td><a href="{{route('products.index',['category_id'=>$category->id])}}" class="btn btn-dark "> المنتجات المرتبطة </a></td> --}}




                    <td class="d-flex justify-content-center align-items-center gap-2">

                 <a href="{{route('categories.edit',$category->id)}}" class="btn btn-primary text-white">
    <i class="fas fa-edit"></i>
</a>

<form action="{{route('categories.destroy',$category->id)}}" method="POST" >
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger  text-white" >
        <i class="fas fa-trash"></i>
    </button>
</form>

                    </td>
                  </tr>
  @endforeach
                  </tbody>

                </table>


{{--
                <div class="mt-3">


{{ $categories->links('pagination::bootstrap-4') }}
    </div> --}}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
