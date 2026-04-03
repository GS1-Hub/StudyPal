<!DOCTYPE html>
<html>
<head>
    <title>StudyPal - Dashboard</title>
    <link rel="icon" href="{{ asset('img/logoico.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>

<body>
    <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">

        <img src="{{ asset('img/logopng.png') }}" alt="StudyPal" style="height: 400px;">

        <div class="d-flex flex-column gap-3 ms-5">
            <button onclick="window.location.href='/calendar'"
                class="btn btn-light btn-lg px-5 fw-semibold">
                Calendar
            </button>
           <button onclick="window.location.href='/uc'"
                class="btn btn-light btn-lg px-5 fw-semibold">
                Course Units
            </button>
            <button type="button" class="btn btn-light btn-lg px-5 fw-semibold">Settings</button>
        </div>
    </div>
</body>
</html>

