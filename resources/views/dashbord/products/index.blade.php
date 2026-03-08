@extends('dashbord.layouts.master')

@section('title')
    المنتجات
@endsection

@section('admin_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>بيانات المنتجات</h1>
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

<div class="card ">




    <div class="card-header">
        <div class="row align-items-center ">

            <!-- زر إضافة منتج -->


            <!-- فورم البحث -->
     {{-- <div class="col-md-9 d-flex justify-content-end">
    <form action="{{ route('products.index') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control form-control "
               placeholder="ابحث عن منتج ..." value="{{ request('search') }}" >

        <button class="btn btn-sm btn-info me-1 ">
            <i class="fas fa-search "></i>
        </button>

        @if(request('search'))
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-dark me-1">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </form>
</div> --}}


        </div>
    </div>


              <!-- /.card-header -->

@include('dashbord.partials.alerts')

              <div class="card-body">

  <div class="d-flex justify-content-start align-items-center mb-3">
        <!-- زر إضافة منتج -->
        <a href="{{ route('products.create') }}" class="btn btn-dark d-inline p-2 me-2">
            <i class="fas fa-plus"></i> إضافة منتج
        </a>

        <!-- زر Excel -->
        <span id="exportBtnContainer" class="  ms-auto" ></span>
    </div>


    

                <table id="example1" class="table table-bordered table-hover text-center">
                  <thead class=" bg-dark">

                  <tr>
                    <th class=" bg-dark">#</th>
                    <th class=" bg-dark">اسم المنتج</th>
                    <th class=" bg-dark no-export" >صورة المنتج </th>
                    <th class=" bg-dark">  السعر  </th>
                    <th class=" bg-dark">  القسم </th>
                    <th class=" bg-dark no-export">العمليات</th>
                  </tr>
                  </thead>
                  <tbody>

                    @foreach ($products as $product )




                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td> {{ $product->name}} </td>

{{-- <td><img src="{{ asset('images/' . $product->image) }}" width="80"></td> --}}
<td>


                            <img src="{{ $product->image ? asset('images/' . $product->image) : asset('images/default.jpg')  }} " width="80">
</td>

                    <td> {{ $product->price}} </td>

                    <td>{{$product->category->name}}</td>


<td class="d-flex justify-content-center align-items-center gap-2">

    <a href="{{route('products.edit', $product->id)}}" class="btn btn-primary text-white  ">
        <i class="fa-solid fa-pen"></i>
    </a>

    <form action="{{route('products.destroy', $product->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger  text-white"
       >
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>

</td>

                  </tr>
                          @endforeach

                  </tbody>

                </table>

    {{-- {!! $products->links('pagination::bootstrap-4') !!} --}}



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
