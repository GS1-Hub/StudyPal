<!DOCTYPE html>
<html>
<head>
    <title>StudyPal - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to StudyPal!</h1>
        <p>You are logged in!</p>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</body>
</html>