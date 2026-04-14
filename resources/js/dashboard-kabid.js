let ticketChart;

// 1. Fungsi untuk merender grafik
function renderMonitoringChart(chartLabels, chartData) {
    const chartCtx = document.getElementById('ticketDonutChart');
    if (!chartCtx) return;

    if (ticketChart) {
        ticketChart.destroy();
    }
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

function toggleModalUsulan() {
    const modal = document.getElementById('modalUsulanKadis');
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
    } else {
        modal.classList.add('hidden');
    }
}




function lihatDetailTiketOperator(uuid, nama) {
    const container = document.getElementById('container-list-tiket');
    const labelNama = document.getElementById('label-nama-operator');
    const modal = document.getElementById('modalUsulanKadis'); // Ambil elemen modal
    
    // 1. Ubah label nama
    if(labelNama) labelNama.innerText = '(Dari ' + nama + ')';

    // 2. Ambil dan Parse Data dari HTML attribute
    // Mengubah string JSON dari data-tiket kembali menjadi Array JavaScript
    const rawData = modal.getAttribute('data-tiket');
    const semuaTiketEligible = rawData ? JSON.parse(rawData) : [];

    // 3. Filter tiket berdasarkan UUID operator
    const tiketOperator = semuaTiketEligible.filter(tiket => tiket.petugas_id === uuid);

    let htmlContent = '';

    // 4. Render HTML Card
    if (tiketOperator.length > 0) {
        tiketOperator.forEach(tiket => {
            const statusClass = tiket.status === 'selesai' ? 'text-green-600' : 'text-red-500';
            const deskripsi = tiket.deskripsi ? tiket.deskripsi : 'Tidak ada deskripsi yang dilampirkan pada tiket ini.';
            const shortDeskripsi = deskripsi.length > 80 ? deskripsi.substring(0, 80) + '...' : deskripsi;
            
            htmlContent += `
                <label class="block cursor-pointer relative group">
                    <input type="radio" name="tiket_id" value="${tiket.uuid}" class="peer hidden" required>
                    
                    <div class="p-4 border-2 border-gray-100 dark:border-gray-700 rounded-2xl hover:border-blue-300 dark:hover:border-blue-500/50 peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all duration-200">
                        <div class="pr-10"> <div class="flex items-center gap-2 mb-2">
                                <span class="inline-block px-2 py-0.5 text-[10px] font-black rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 tracking-wider">
                                    ${tiket.no_tiket}
                                </span>
                                <span class="text-[10px] font-black uppercase tracking-wider ${statusClass}">
                                    • ${tiket.status}
                                </span>
                            </div>
                            <p class="text-sm text-gray-800 dark:text-gray-200 font-medium leading-relaxed">
                                ${shortDeskripsi}
                            </p>
                        </div>
                    </div>
                    
                    <div class="absolute top-5 right-5 w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-600 peer-checked:border-blue-600 peer-checked:bg-blue-600 pointer-events-none transition-all duration-200"></div>
                    
                    <i class="ti ti-check absolute top-5 right-5 w-6 h-6 flex items-center justify-center text-white opacity-0 peer-checked:opacity-100 text-xs font-bold pointer-events-none transition-all duration-200"></i>
                </label>
            `;
        });
    } else {
        htmlContent = `
            <div class="p-8 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl flex flex-col items-center justify-center h-full">
                <i class="ti ti-inbox text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mt-2">Operator ini belum memiliki tiket berstatus Selesai/Ditolak.</p>
            </div>
        `;
    }

    // 5. Masukkan HTML ke dalam modal dan buka modal
    container.innerHTML = htmlContent;
    modal.classList.remove('hidden');
}


window.initDashboard = initDashboard;
window.toggleModalUsulan = toggleModalUsulan; 
window.lihatDetailTiketOperator = lihatDetailTiketOperator;