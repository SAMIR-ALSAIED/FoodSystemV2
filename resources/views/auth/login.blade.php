<x-guest-layout  title="تسجيل الدخول">

      

    <div class="card card-outline card-primary shadow-lg">
        <div class="card-header text-center">
            <h3 class="h3"><b>تسجيل</b> الدخول</h3>
        </div>
        <div class="card-body login-card-body">

            @if (session('status'))
                <div class="alert alert-success mb-3" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <div class="input-group">
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="البريد الإلكتروني"  autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="كلمة السر">
                        <span class="input-group-text" style="cursor:pointer" onclick="togglePassword()">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>



                <div class="row align-items-center">
                    <div class="col-7">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">تذكرني</label>
                        </div>
                    </div>
                    <div class="col-5">
                        <button type="submit" class="btn btn-dark btn-block shadow-sm">
                            دخول <i class="fas fa-sign-in-alt ml-1"></i>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>



</x-guest-layout>
