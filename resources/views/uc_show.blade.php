<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('img/logoico.ico') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="{{ asset('css/uc_show.css') }}" rel="stylesheet">
    <title>{{ $uc->name }}</title>
</head>

<body>
    <x-navbar />
    <h1>{{ $uc->name }}</h1>
    <div class="uc-wrapper">
        <div>
            <h1>Tasks</h1>
            <p>Create a task for this UC</p>
        </div>

        @if(session('success'))
        <div class="success-msg">{{ session('success') }}</div>
        @endif

        <div class="uc-list">
            @forelse($tasks as $task)
            <div class="uc-item">
                <strong><span>{{ $task->name }}</span></strong>
            </div>
            @empty
            <div class="uc-empty">
                You don't have any Task yet.
            </div>
            @endforelse
        </div>

        <form method="POST" action="{{ route('tasks.store') }}" class="uc-form">
            @csrf
            <input type="hidden" name="uc_id" value="{{ $uc->id }}">
            <label for="name">New Task</label>
            <div>
                <input type="text" name="name" id="name" placeholder="Type the course task name">
                <button type="submit">Create</button>
            </div>
        </form>
    </div>
    <a href="{{ route('ucs.index') }}" class="back-link">← Back</a>
</body>

</html>