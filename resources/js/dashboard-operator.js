document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('performanceChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    const rawData = JSON.parse(canvas.dataset.tren);

    const labels = rawData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });
    const values = rawData.map(item => item.total);

    const isDark = document.documentElement.classList.contains('dark');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)');
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Tiket Terproses',
                data: values,
                fill: true,
                backgroundColor: gradient,
                borderColor: '#3b82f6',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 12,
                    cornerRadius: 8,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: values.length > 0 ? Math.max(...values) + 2 : 5,
                    ticks: {
                        stepSize: 1,
                        color: '#9ca3af'
                    },
                    grid: {
                        color: isDark ? 'rgba(75, 85, 99, 0.3)' : 'rgba(243, 244, 246, 1)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: { color: '#9ca3af' },
                    grid: { display: false }
                }
            }
        }
    });
});