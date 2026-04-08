<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('img/logoico.ico') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.js"></script>
</head>
<title>Calendar</title>
</head>

<body>
<x-navbar />

<div class="calendar-wrapper">
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
        <p id="task-modal-state" style="font-size: 0.85rem; margin-bottom: 12px;"></p>
        <label style="color: #666; font-size: 0.9rem;">Notes</label>
        <textarea id="task-notes" rows="4" style="width:100%; margin-top: 8px; padding: 10px; border-radius: 8px; border: 1px solid #ddd; font-size: 0.95rem; resize: vertical;"></textarea>
        <div style="display: flex; gap: 10px; margin-top: 16px;">
            <button onclick="saveNotes()" class="btn-save">Save</button>
            <button onclick="updateState('doing')" class="btn-doing">▶ Start</button>
            <button onclick="updateState('done')" class="btn-done">✔ Done</button>
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
