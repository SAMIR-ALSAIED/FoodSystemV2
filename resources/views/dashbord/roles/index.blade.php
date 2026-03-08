@extends('dashbord.layouts.master')

@section('title')
    صلاحيات
@endsection

@section('admin_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>بيانات الصلاحيات</h1>
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
            <div class="col-md-3 mb-2 mb-md-0">






            <!-- فورم البحث -->
     <div class="col-md-9 d-flex justify-content-end">
    {{-- <form action="" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control form-control "
               placeholder="ابحث عن منتج ..." value="{{ request('search') }}" >

        <button class="btn btn-sm btn-info me-1 ">
            <i class="fas fa-search "></i>
        </button>

        @if(request('search'))
            <a href="{{route('clients.index')}}" class="btn btn-sm btn-dark me-1">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </form> --}}
</div>


        </div>
    </div>
              <!-- /.card-header -->

              @include('dashbord.partials.alerts')

              <div class="card-body">



  <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- زر إضافة منتج -->



        <a href="{{ route('roles.create') }}" class="btn btn-dark d-inline p-2 me-2">
            <i class="fas fa-plus"></i> إضافة صلاحية
        </a>

        <!-- زر Excel -->
        <span id="exportBtnContainer" class="d-inline"></span>
    </div>

                <table id="example1" class="table table-bordered table-hover text-center">
                  <thead>

                  <tr>
                    <th>#</th>
                    <th>اسم الصلاحية </th>
                    <th>العمليات</th>
                  </tr>
                  </thead>
                  <tbody>



                    @foreach ($roles as $role )

                  <tr>
                    <td>{{$loop->iteration}} </td>
                    <td>  {{$role->name}}</td>


                    <td>




                 <a href="{{route('roles.edit',$role->id)}}" class="btn btn-primary">
    <i class="fas fa-edit"></i>

</a>




<form action="{{route('roles.destroy',$role->id)}}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" >
        <i class="fas fa-trash"></i>
    </button>
</form>


                    </td>
                  </tr>

                    @endforeach
                  </tbody>

                </table>
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
