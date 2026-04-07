<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('img/logoico.ico') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="{{ asset('css/uc.css') }}" rel="stylesheet">
    <title>UC</title>
</head>
<body>
    <x-navbar />
    <div class="uc-page">
        <div class="uc-box">
            <div class="uc-header">
                <h1>Course Units</h1>
                <p class="uc-subtitle">Select a UC or create a new one.</p>
            </div>

            @if(session('success'))
                <div class="uc-success">{{ session('success') }}</div>
            @endif

            <div class="uc-list">
                @forelse($ucs as $uc)
                    <a href="{{ route('ucs.show', $uc->id) }}" class="uc-item">
                        <strong><span>{{ $uc->name }}</span></strong>
                        <span class="uc-arrow">></span>
                    </a>
                @empty
                    <div class="uc-empty">
                        You don't have any UC yet.
                    </div>
                @endforelse
            </div>

            <form method="POST" action="{{ route('ucs.store') }}" class="uc-form">
                @csrf

                <label for="name">New UC</label>
                <div class="uc-form-row">
                    <input type="text" name="name" id="name" placeholder="Type the course unit name">
                    <button type="submit">Create</button>
                </div>
            </form>
            <a href="{{ route('dashboard') }}" class="back-link">← Back</a>
        </div>
    </div>
     
</body>
</html>