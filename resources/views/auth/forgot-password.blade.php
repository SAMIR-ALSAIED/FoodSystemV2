<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Forgot your password? Enter your email to reset it.</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="input-group mb-3">
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Email Password Reset Link
                        </button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-0">
                <a href="{{ route('login') }}" class="text-center">Back to login</a>
            </p>
        </div>
    </div>
</x-guest-layout>
