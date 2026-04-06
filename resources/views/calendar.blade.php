<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('img/logoico.ico') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.js"></script>
    <title>Calendar</title>
</head>

<body>
    <div class="container">
        <h1>📅 Calendar</h1>
        <div id="calendar"></div>
    </div>

    <!-- Popup -->
    <div id="modal" class="modal hidden">
        <div class="modal-box">
            <h2>Assign Task</h2>
            <p id="modal-date"></p>
            <ul id="task-list"></ul>
            <button onclick="closeModal()" class="btn-cancel">Cancel</button>
        </div>
    </div>

    <script>
        var calendarEvents = @json($events);
        var csrfToken = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/calendar.js') }}"></script>
</body>

</html>