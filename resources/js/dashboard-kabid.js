let ticketChart;

// 1. Fungsi untuk merender grafik
function renderMonitoringChart(chartLabels, chartData) {
    const chartCtx = document.getElementById('ticketDonutChart');
    if (!chartCtx) return;

    if (ticketChart) {
        ticketChart.destroy();
    }

    // Pastikan library Chart.js sudah terload sebelum ini dipanggil
    ticketChart = new Chart(chartCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            cutout: '80%',
            plugins: { legend: { display: false } }
        }
    });
}

// 2. Fungsi Fetch Data AJAX
function fetchData(url, config) {
    const contentBody = document.getElementById('ajax-table-content');
    if (contentBody) contentBody.style.opacity = '0.3';

    fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "text/html"
        }
    })
    .then(response => {
        if (!response.ok) throw new Error("Gagal memuat data");
        return response.text();
    })
    .then(html => {
        if (contentBody) {
            contentBody.innerHTML = html;
            contentBody.style.opacity = '1';
        }
        // Gambar ulang grafik tepat setelah tabel diganti
        renderMonitoringChart(config.labels, config.data);
        // Update URL bar tanpa refresh
        window.history.pushState(null, null, url);
    })
    .catch(error => {
        console.error("AJAX Error:", error);
        if (contentBody) contentBody.style.opacity = '1';
    });
}

// 3. Fungsi Inisialisasi Utama
function initDashboard(config) {
    renderMonitoringChart(config.labels, config.data);

    // Jam Real-time
    setInterval(() => {
        const clock = document.getElementById('realtime-clock');
        if (clock) clock.textContent = new Date().toLocaleTimeString('en-GB');
    }, 1000);

    // Mencegat klik pagination
    document.addEventListener('click', function (e) {
        const link = e.target.closest('#table-container a');
        if (link && link.href && link.href.includes('page=')) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            fetchData(link.href, config);
        }
    });
}

// --- PERBAIKAN KRUSIAL: Ekspos fungsi ke Window agar bisa dipanggil dari Blade ---
// Tanpa ini, Vite akan menyembunyikan fungsi ini dari Blade
window.initDashboard = initDashboard;
