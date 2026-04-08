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
            <h2>Velocidade por task</h2>
            <div class="legend">
                <span><span class="legend-dot" style="background:#48bb78;"></span> Bom (1-2 dias)</span>
                <span><span class="legend-dot" style="background:#ed8936;"></span> Médio (3-4 dias)</span>
                <span><span class="legend-dot" style="background:#e53e3e;"></span> Mau (5+ dias)</span>
                <span><span class="legend-dot" style="background:#764ba2;"></span> Em progresso</span>
            </div>
            <div style="position: relative; width: 100%; height: 360px;">
                <canvas id="speedChart" role="img" aria-label="Bubble chart showing task completion speed">Task speed chart.</canvas>
            </div>
        </div>

        <div class="pending-card">
            <h2>Pendentes</h2>
            <p class="pending-count">{{ count($pending) }} tasks por fazer</p>

            @forelse($pending as $task)
                <div class="pending-item">
                    <p class="pending-name">{{ $task['name'] }}</p>
                    <p class="pending-meta">
                        📚 {{ $task['uc'] }} ·
                        <span class="state-badge state-{{ $task['state'] }}">{{ $task['state'] }}</span>
                    </p>
                </div>
            @empty
                <p style="color: #aaa; font-size: 13px;">Nenhuma task pendente 🎉</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    var taskData = @json($tasks);

    var datasets = [
        {
            label: 'Bom',
            data: taskData.filter(t => t.done && t.score === 'good').map((t, i) => ({ x: i, y: t.days, r: 10, name: t.name, uc: t.uc })),
            backgroundColor: 'rgba(72,187,120,0.7)',
            borderColor: '#48bb78',
            borderWidth: 1.5,
        },
        {
            label: 'Médio',
            data: taskData.filter(t => t.done && t.score === 'medium').map((t, i) => ({ x: i, y: t.days, r: 10, name: t.name, uc: t.uc })),
            backgroundColor: 'rgba(237,137,54,0.7)',
            borderColor: '#ed8936',
            borderWidth: 1.5,
        },
        {
            label: 'Mau',
            data: taskData.filter(t => t.done && t.score === 'bad').map((t, i) => ({ x: i, y: t.days, r: 10, name: t.name, uc: t.uc })),
            backgroundColor: 'rgba(229,62,62,0.7)',
            borderColor: '#e53e3e',
            borderWidth: 1.5,
        },
        {
            label: 'Em progresso',
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
                        label: ctx => `${ctx.raw.name} (${ctx.raw.uc}): ${ctx.raw.y} dias`
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
                    title: { display: true, text: 'Dias para completar', color: 'rgba(255,255,255,0.8)', font: { size: 12 } },
                    min: 0,
                    grid: { color: 'rgba(255,255,255,0.15)' },
                    ticks: { color: 'rgba(255,255,255,0.8)' }
                }
            },
            layout: { padding: 20 }
        }
    });
</script>
</body>

</html>
