@if (session('success'))
    <div class="alert alert-primary" role="alert">
        {{ session('success') }}
    </div>
@elseif (session('error'))
    <div class="alert alert-primary" role="alert">
        {{ session('error') }}
    </div>
@endif
