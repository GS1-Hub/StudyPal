<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('img/logoico.ico') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="{{ asset('css/stats.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <title>Stats</title>
</head>

<body>
<x-navbar />

<div class="stats-wrapper">
    <h1>📊 Stats</h1>

    <div class="stats-grid">
        <div class="chart-card">
            <h2>Speed Task Stats</h2>
            <div class="legend">
                <span><span class="legend-dot" style="background:#48bb78;"></span> Godd (1-2 days)</span>
                <span><span class="legend-dot" style="background:#ed8936;"></span> Medium (3-4 days)</span>
                <span><span class="legend-dot" style="background:#e53e3e;"></span> Bad (5+ days)</span>
                <span><span class="legend-dot" style="background:#764ba2;"></span> In progress </span>
            </div>
            <div style="position: relative; width: 100%; height: 360px;">
                <canvas id="speedChart" role="img" aria-label="Bubble chart showing task completion speed">Task speed chart.</canvas>
            </div>
        </div>

        <div class="pending-card">
            <h2>Waiting</h2>
            <p class="pending-count">{{ count($pending) }} ToDo Tasks</p>

            @forelse($pending as $task)
                <div class="pending-item" onclick="openPendingModal({{ json_encode($task) }})">
                    <p class="pending-name">{{ $task['name'] }}</p>
                    <p class="pending-meta">
                        📚 {{ $task['uc'] }} ·
                        <span class="state-badge state-{{ $task['state'] }}">{{ $task['state'] }}</span>
                    </p>
                </div>
            @empty
                <p style="color: rgba(255,255,255,0.5); font-size: 13px;">Nenhuma task pendente 🎉</p>
            @endforelse
        </div>
    </div>
</div>

<div id="pending-modal" class="modal-overlay hidden">
    <div class="modal-box">
        <h2 id="modal-title"></h2>
        <p id="modal-uc"></p>
        <p id="modal-state"></p>
        <label>Notes</label>
        <textarea id="modal-notes" rows="4"></textarea>
        <div class="modal-actions">
            <button onclick="saveModalNotes()" class="btn-save">Save</button>
            <button onclick="updateModalState('doing')" class="btn-doing">▶ Start</button>
            <button onclick="updateModalState('done')" class="btn-done">✔ Done</button>
            <button onclick="closePendingModal()" class="btn-cancel">Cancel</button>
        </div>
    </div>
</div>

<script>
    var taskData = @json($tasks);
    var csrfToken = '{{ csrf_token() }}';
    var selectedTaskId = null;

    var datasets = [
        {
            label: 'Good',
            data: taskData.filter(t => t.done && t.score === 'good').map((t, i) => ({ x: i, y: t.days, r: 10, name: t.name, uc: t.uc })),
            backgroundColor: 'rgba(72,187,120,0.7)',
            borderColor: '#48bb78',
            borderWidth: 1.5,
        },
        {
            label: 'Medium',
            data: taskData.filter(t => t.done && t.score === 'medium').map((t, i) => ({ x: i, y: t.days, r: 10, name: t.name, uc: t.uc })),
            backgroundColor: 'rgba(237,137,54,0.7)',
            borderColor: '#ed8936',
            borderWidth: 1.5,
        },
        {
            label: 'Bad',
            data: taskData.filter(t => t.done && t.score === 'bad').map((t, i) => ({ x: i, y: t.days, r: 10, name: t.name, uc: t.uc })),
            backgroundColor: 'rgba(229,62,62,0.7)',
            borderColor: '#e53e3e',
            borderWidth: 1.5,
        },
        {
            label: 'In progress',
            data: taskData.filter(t => !t.done).map((t, i) => ({ x: i, y: t.days, r: 10, name: t.name, uc: t.uc })),
            backgroundColor: 'rgba(118,75,162,0.7)',
            borderColor: '#764ba2',
            borderWidth: 1.5,
        },
    ];

    new Chart(document.getElementById('speedChart'), {
        type: 'bubble',
        data: { datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.raw.name} (${ctx.raw.uc}): ${ctx.raw.y} days`
                    }
                }
            },
            scales: {
                x: {
                    display: false,
                    min: -1,
                    max: taskData.length + 1,
                },
                y: {
                    title: { display: true, text: 'Days:', color: 'rgba(255,255,255,0.8)', font: { size: 12 } },
                    min: 0,
                    grid: { color: 'rgba(255,255,255,0.15)' },
                    ticks: { color: 'rgba(255,255,255,0.8)' }
                }
            },
            layout: { padding: 20 }
        }
    });

    function openPendingModal(task) {
        selectedTaskId = task.id;
        document.getElementById('modal-title').textContent = task.name;
        document.getElementById('modal-uc').textContent = '📚 ' + task.uc;
        var stateLabels = { todo: '⬜ Todo', doing: '🟠 Doing', done: '🟢 Done' };
        document.getElementById('modal-state').textContent = stateLabels[task.state] || task.state;
        document.getElementById('modal-notes').value = task.notes || '';
        document.getElementById('pending-modal').classList.remove('hidden');
    }

    function closePendingModal() {
        document.getElementById('pending-modal').classList.add('hidden');
        selectedTaskId = null;
    }

    function saveModalNotes() {
        var notes = document.getElementById('modal-notes').value;
        fetch('/task/' + selectedTaskId + '/notes', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ notes: notes }),
        }).then(() => {
            closePendingModal();
            showToast('✅ Notes saved!');
            setTimeout(() => location.reload(), 1500);
        });
    }

    function updateModalState(state) {
        fetch('/task/' + selectedTaskId + '/state', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ state: state }),
        }).then(() => {
            closePendingModal();
            showToast(state === 'done' ? '✅ Task done!' : '▶ Task started!');
            setTimeout(() => location.reload(), 1500);
        });
    }

    function showToast(msg) {
        var toast = document.createElement('div');
        toast.textContent = msg;
        toast.style.cssText = 'position:fixed;bottom:24px;right:24px;background:#764ba2;color:#fff;padding:12px 20px;border-radius:8px;font-size:0.95rem;z-index:9999;';
        document.body.appendChild(toast);
    }
</script>
</body>

</html>
