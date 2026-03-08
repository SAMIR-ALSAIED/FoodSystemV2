@extends('dashbord.layouts.master')

@section('title')
    اسليدر الموقع
@endsection

@section('admin_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <h1>بيانات الاقسام</h1> --}}
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





        </div>
    </div>
              <!-- /.card-header -->





              <div class="card-body">


 <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- زر إضافة منتج -->
        <a href="{{ route('sliders.create') }}" class="btn btn-dark d-inline p-2 me-2">
            <i class="fas fa-plus"></i> إضافة سليدر
        </a>

        <!-- زر Excel -->
    <span id="exportBtnContainer"></span>

    </div>





                <table  class="table table-bordered table-hover text-center">
                  <thead>
        @include('dashbord.partials.alerts')
                  <tr>
                    <th class=" ">#</th>
                    <th class=" "> العنوان الرئيسي  </th>
                    <th>  العنوان الفرعي</th>

                    <th>   الصورة </th>

                    <th class=" ">العمليات</th>
                  </tr>
                  </thead>




                  <tbody>


   @foreach ($sliders as $slider )
                  <tr>
                    <td></td>
                    <td> {{  $slider->big_title }} </td>
                    <td> {{  $slider->small_title }} </td>
                  <td>

<img src="{{ asset('images/sliders/' . $slider->image) }}" width="80">

</td>




                    <td class="d-flex justify-content-center align-items-center gap-2">

                 {{-- <a href="" class="btn btn-primary text-white">
    <i class="fas fa-edit"></i>
</a> --}}

<form action="{{ route('sliders.destroy',$slider->id) }}" method="POST" >
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
