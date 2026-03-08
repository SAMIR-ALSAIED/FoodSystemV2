
@if(session('success'))
    <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center  alert-dismissible fade show" role="alert">
        <i class="fas fa-times-circle me-1"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning text-center alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-1"></i>
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info  text-center alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle me-1"></i>
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


@if($errors->count())
    <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
        <strong>حدثت أخطاء:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            document.querySelectorAll('.alert').forEach(function (alert) {
                alert.classList.remove('show');
                alert.classList.add('hide');

                setTimeout(() => alert.remove(), 500);
            });
        }, 4000);
    });
</script>
