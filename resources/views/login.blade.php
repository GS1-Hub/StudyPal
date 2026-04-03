<!DOCTYPE html>
<html>

<head>
    <title>StudyPal</title>
    <link rel="icon" href="{{ asset('img/logoico.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body>
    <div class="card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo.png') }}" alt="StudyPal" style="height: 200px;">
            </div>

            <h4 class="text-center fw-bold mb-1">Welcome back!</h4>
            <p class="text-center text-muted mb-4">Sign in to your account</p>

            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="example@email.com">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
                <p class="text-center text-muted mt-3 mb-0">
                    Don't have an account? <a href="{{ url('/register') }}">Sign in</a>
                </p>
                @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
                @endif
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>