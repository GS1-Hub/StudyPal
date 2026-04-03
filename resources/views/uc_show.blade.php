<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('img/logoico.ico') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/uc.css') }}" rel="stylesheet">
    <title>{{ $uc->name }}</title>
</head>
<body>
    <h1>{{ $uc->name }}</h1>

    <a href="{{ route('ucs.index') }}">Back</a>
</body>
</html>