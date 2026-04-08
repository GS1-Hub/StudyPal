<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid">
            <a href="/dashboard" class="navbar-brand">📚 Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/calendar">Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/uc">Course Units</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/stats">Stats</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
</body>
</html>

