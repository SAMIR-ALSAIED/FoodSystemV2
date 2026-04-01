@extends('dashbord.layouts.master')
@section('title')
    المستخدمين
@endsection
@section('admin_content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>تعديل مستخدم جديد </h1>
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
          <form action="{{route('users.update',$user->id)}}" method="POST">
            @csrf
            @method('PUT')
          <div class="card-body">
            <div class="row">

              {{-- إخفاء حقول الاسم والايميل والباسورد لو admin --}}
              @if(!$user->hasRole('admin'))
              <div class="col-12">
                <div class="form-group">
                  <label>اسم المستخدم</label>
                  <input type="text" class="form-control" name="name" value="{{$user->name}}">
                  @error('name')
                    <small class="text-danger mt-3">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>الايميل</label>
                  <input type="email" class="form-control" name="email" value="{{$user->email}}">
                  @error('email')
                    <small class="text-danger mt-3">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>الباسورد</label>
                  <input type="password" class="form-control" name="password">
                  @error('password')
                    <small class="text-danger mt-3">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              @else
              <div class="col-12">
                <div class="form-group">
                  <label>اسم المستخدم</label>
                  <input type="text" class="form-control" value="{{$user->name}}" disabled>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>الايميل</label>
                  <input type="email" class="form-control" value="{{$user->email}}" disabled>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>الباسورد</label>
                  <input type="password" class="form-control" disabled>
                </div>
              </div>
              @endif

              <div class="col-12">
                <div class="form-group">
                  <label>الدور</label>
                  <select name="role" class="form-control" {{ $user->hasRole('admin') ? 'disabled' : '' }}>
                    <option value="">اختر الدور</option>
                    @foreach($roles->where('name', '!=', 'admin') as $role)
                      <option
                        value="{{ $role->id }}"
                        {{ old('role', isset($user) ? $user->roles->first()?->id : null) == $role->id ? 'selected' : '' }}
                      >
                        {{ $role->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('role')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>

              @if(!$user->hasRole('admin'))
              <button type="submit" class="btn btn-primary">حفظ</button>
              @endif

            </div>
          </div>
          </form>
        </div>
      </div>
    </section>
  </div>
@endsection