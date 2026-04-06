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

    <div id="task-modal" class="modal hidden">
        <div class="modal-box">
            <h2 id="task-modal-title"></h2>
            <p id="task-modal-uc" style="color: #764ba2; font-weight: bold; margin-bottom: 16px;"></p>
            <label style="color: #666; font-size: 0.9rem;">Notes</label>
            <textarea id="task-notes" rows="4" style="width:100%; margin-top: 8px; padding: 10px; border-radius: 8px; border: 1px solid #ddd; font-size: 0.95rem; resize: vertical;"></textarea>
            <div style="display: flex; gap: 10px; margin-top: 16px;">
                <button onclick="saveNotes()" class="btn-save">Save</button>
                <button onclick="closeTaskModal()" class="btn-cancel">Cancel</button>
            </div>
        </div>
    </div>
    
    <script>
        var calendarEvents = @json($events);
        var csrfToken = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/calendar.js') }}"></script>
</body>

</html>