<x-guest-layout title="تسجيل الدخول">

<style>
    .role-selector { display: flex; gap: 8px; margin-bottom: 20px; }

    .role-card {
        flex: 1;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        padding: 12px 6px;
        text-align: center;
        cursor: pointer;
        background: #fff;
        transition: all .22s ease;
        user-select: none;
    }
    .role-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.1); }

    .role-card .role-icon  { font-size: 24px; display: block; margin-bottom: 5px; }
    .role-card .role-title { font-size: .78rem; font-weight: 700; display: block; color: #495057; }
    .role-card .role-sub   { font-size: .7rem; color: #adb5bd; display: block; }

    .role-card.active-admin        { border-color: #ffc107; background: #fffdf0; box-shadow: 0 4px 14px rgba(255,193,7,.25); }
    .role-card.active-cashier      { border-color: #007bff; background: #f0f6ff; box-shadow: 0 4px 14px rgba(0,123,255,.2); }
    .role-card.active-KitchenStaff { border-color: #28a745; background: #f0fff4; box-shadow: 0 4px 14px rgba(40,167,69,.2); }

    .role-card.active-admin        .role-title { color: #856404; }
    .role-card.active-cashier      .role-title { color: #004085; }
    .role-card.active-KitchenStaff .role-title { color: #155724; }

    @keyframes flashFill {
        0%   { background-color: #fff; }
        40%  { background-color: #fffbe6; }
        100% { background-color: #fff; }
    }
    .flash-fill { animation: flashFill .5s ease; }
</style>

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

        {{-- <p class="text-muted text-center mb-2" style="font-size:.8rem;">اختر صلاحيتك للدخول السريع</p> --}}
        {{-- <div class="role-selector">
            <div class="role-card" id="btn-admin" onclick="quickLogin('admin')">
                <span class="role-title">Admin</span>
            </div>
            <div class="role-card" id="btn-cashier" onclick="quickLogin('cashier')">
                <span class="role-title">Cashier</span>
            </div>
            <div class="role-card" id="btn-KitchenStaff" onclick="quickLogin('KitchenStaff')">
                <span class="role-title">KitchenStaff</span>
            </div>
        </div> --}}

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="">

            <div class="mb-3">
                <div class="input-group">
                    <input type="email" id="emailInput" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="البريد الإلكتروني" autofocus>
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

{{-- <script>
    const roleCredentials = {
        admin:        { email: 'samir@gmail.com',   password: '12345678' },
        cashier:      { email: 'mohamed@gmail.com', password: '123456'   },
        KitchenStaff: { email: 'ali@gmail.com',     password: '123456'   },
    };

    // ✅ مصفوفة الأدوار الصح
    const allRoles = ['admin', 'cashier', 'KitchenStaff'];

    function quickLogin(role) {
        // إزالة كل الـ active classes
        allRoles.forEach(r => {
            document.getElementById('btn-' + r).className = 'role-card';
        });

        // تفعيل الزر المختار
        document.getElementById('btn-' + role).classList.add('active-' + role);

        const creds      = roleCredentials[role];
        const emailEl    = document.getElementById('emailInput');
        const passwordEl = document.getElementById('password');

        emailEl.value    = creds.email;
        passwordEl.value = creds.password;
        document.getElementById('roleInput').value = role;

        [emailEl, passwordEl].forEach(el => {
            el.classList.remove('flash-fill');
            void el.offsetWidth;
            el.classList.add('flash-fill');
        });

        document.getElementById('loginForm').submit();
    }

    function togglePassword() {
        const pw   = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            pw.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script> --}}

</x-guest-layout>