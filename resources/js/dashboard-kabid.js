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
            const deskripsiLengkap = tiket.deskripsi ? tiket.deskripsi : 'Tidak ada deskripsi yang dilampirkan pada tiket ini.';
            const shortDeskripsi = deskripsiLengkap.length > 80 ? deskripsiLengkap.substring(0, 80) + '...' : deskripsiLengkap;
            
            // Render Lampiran (Foto)
            let lampiranHtml = '';
            if (tiket.lampiran) {
                const minioBaseUrl = 'http://localhost:9000/diskominfo-assets';
                // Sesuaikan '/storage/' jika letak symlink/path kamu berbeda
                lampiranHtml = `
                    <div class="mb-3">
                        <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1.5">Lampiran Laporan:</span>
                        <a href="${minioBaseUrl}/${tiket.lampiran}" target="_blank" class="inline-block hover:opacity-80 transition-opacity">
                            <img src="${minioBaseUrl}/${tiket.lampiran}" alt="Lampiran" class="max-h-32 rounded-lg border border-gray-200 dark:border-gray-700 object-cover shadow-sm">
                        </a>
                    </div>
                `;
            }

            // Render Daftar Komentar
            let komentarHtml = '';
            if (tiket.komentar && tiket.komentar.length > 0) {
                komentarHtml = '<div class="space-y-2">';
                komentarHtml += '<span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1.5">Komentar Operator:</span>';
                
                tiket.komentar.forEach(kom => {
                    const namaUser = kom.user ? kom.user.nama : 'Operator';
                    komentarHtml += `
                        <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <p class="text-[10px] font-black text-blue-600 dark:text-blue-400 mb-0.5">${namaUser}</p>
                            <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">${kom.komentar}</p>
                        </div>
                    `;
                });
                komentarHtml += '</div>';
            } else {
                komentarHtml = `
                    <div>
                        <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1.5">Komentar Operator:</span>
                        <p class="text-xs text-gray-400 italic bg-gray-50 dark:bg-gray-800 p-3 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">Belum ada komentar.</p>
                    </div>
                `;
            }

            htmlContent += `
                <div class="mb-4 relative">
                    <label class="block cursor-pointer relative group">
                        <input type="radio" name="tiket_id" value="${tiket.uuid}" class="peer hidden" required>
                        
                        <div class="p-4 border-2 border-gray-100 dark:border-gray-700 rounded-2xl hover:border-blue-300 dark:hover:border-blue-500/50 peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all duration-200 relative z-10">
                            <div class="pr-10"> 
                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-black rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 tracking-wider">
                                        ${tiket.no_tiket}
                                    </span>
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-black rounded-md bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 tracking-wider">
                                        ${tiket.layanan ? tiket.layanan.nama : 'Layanan'}
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
                        
                        <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-600 peer-checked:border-blue-600 peer-checked:bg-blue-600 pointer-events-none transition-all duration-200 z-20"></div>
                        <i class="ti ti-check absolute top-4 right-4 w-6 h-6 flex items-center justify-center text-white opacity-0 peer-checked:opacity-100 text-xs font-bold pointer-events-none transition-all duration-200 z-20"></i>
                    </label>

                    <div class="flex justify-end mt-2 px-1">
                        <button type="button" onclick="document.getElementById('detail-${tiket.uuid}').classList.toggle('hidden')" class="text-[11px] font-bold text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors flex items-center gap-1.5 bg-gray-100 hover:bg-blue-50 dark:bg-gray-800 dark:hover:bg-blue-900/30 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700">
                            <i class="ti ti-list-details text-sm"></i> Buka Detail, Foto & Komentar
                        </button>
                    </div>

                    <div id="detail-${tiket.uuid}" class="hidden mt-3 p-4 bg-white dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                        <div class="mb-3">
                            <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1.5">Deskripsi Lengkap:</span>
                            <p class="text-xs text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                ${deskripsiLengkap}
                            </p>
                        </div>
                        ${lampiranHtml}
                        ${komentarHtml}
                    </div>
                </div>
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

document.getElementById('formUsulanKadis').addEventListener('submit', function(e) {
    e.preventDefault(); // 🛑 WAJIB: Mencegah form memuat ulang URL baru

    let formData = new FormData(this);
    let submitBtn = this.querySelector('button[type="submit"]');
    let originalText = submitBtn.innerHTML;
    
    // Efek loading di tombol
    submitBtn.innerHTML = '<i class="ti ti-loader animate-spin"></i> Mengirim...';
    submitBtn.disabled = true;

    // Ambil action URL (Pastikan di form HTML sudah ada atribut data-url="{{ route('kabid.usulan.store') }}")
    let actionUrl = this.getAttribute('data-url');

    if (!actionUrl) {
        alert("Error: URL Form (data-url) belum diatur!");
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        return;
    }

    fetch(actionUrl, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            "Accept": "application/json" // 🛑 WAJIB: Memaksa server Laravel membalas dengan JSON, BUKAN redirect
        },
        body: formData
    })
    .then(async response => {
        const data = await response.json().catch(() => ({})); // Tangkap JSON
        if (!response.ok) {
            throw new Error(data.message || "Terjadi kesalahan sistem (Error " + response.status + ").");
        }
        return data;
    })
    .then(data => {
        // 1. Sembunyikan Modal Form Usulan
        document.getElementById('modalUsulanKadis').classList.add('hidden');
        document.getElementById('formUsulanKadis').reset();
        
        // 2. Tampilkan Modal Alert Custom - SUKSES
        tampilkanAlert(true, "Berhasil!", data.message || "Usulan prioritas berhasil dikirim ke Kadis.");
    })
    .catch(error => {
        // Tampilkan Modal Alert Custom - GAGAL
        tampilkanAlert(false, "Gagal Mengirim!", error.message);
    })
    .finally(() => {
        // Kembalikan tombol ke semula
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// === Fungsi Pengendali Modal Alert === //

window.tampilkanAlert = function(isSuccess, title, message) {
    const modal = document.getElementById('modalAlertCustom');
    const icon = document.getElementById('alertIcon');
    
    if (isSuccess) {
        icon.innerHTML = '<i class="ti ti-circle-check text-[70px] text-green-500 drop-shadow-md"></i>';
    } else {
        icon.innerHTML = '<i class="ti ti-alert-triangle text-[70px] text-red-500 drop-shadow-md"></i>';
    }
    
    document.getElementById('alertTitle').innerText = title;
    document.getElementById('alertMessage').innerText = message;
    
    modal.classList.remove('hidden');
}

window.tutupAlertDanKembali = function() {
    // 1. Tutup Modal Alert
    document.getElementById('modalAlertCustom').classList.add('hidden');
    
    // 2. (Opsional) Refresh tabel atau data dashboard jika diperlukan
    // Jika Anda ingin halamannya refresh murni untuk memperbarui data:
    window.location.reload(); 
} 

document.addEventListener('DOMContentLoaded', function() {
    const bridge = document.getElementById('dashboard-data-bridge');
    
    if (bridge && typeof window.initDashboard === 'function') {
        // Ambil data dari attribute HTML
        const labels = JSON.parse(bridge.getAttribute('data-labels'));
        const data = JSON.parse(bridge.getAttribute('data-data'));

        window.initDashboard({
            labels: labels,
            data: data
        });
    }
});

window.confirmHapusUsulan = function(uuid) {
    Swal.fire({
        title: 'Batalkan Usulan?',
        text: "Apakah Anda yakin ingin membatalkan usulan prioritas untuk tiket ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444', 
        cancelButtonColor: '#6b7280', 
        confirmButtonText: '<i class="ti ti-trash"></i> Ya, Batalkan!',
        cancelButtonText: 'Batal',
        reverseButtons: true 
    }).then((result) => {
        if (result.isConfirmed) {
            
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang membatalkan usulan prioritas',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // PERBAIKAN: URL sudah disesuaikan dengan web.php (tanpa /kabid)
            fetch(`/usulan/${uuid}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || "Gagal membatalkan usulan.");
                return data;
            })
            .then(data => {
                Swal.fire({
                    title: 'Dibatalkan!',
                    text: data.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload(); 
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Gagal!',
                    text: error.message,
                    icon: 'error'
                });
            });
        }
    });
}


window.initDashboard = initDashboard;
window.toggleModalUsulan = toggleModalUsulan; 
window.lihatDetailTiketOperator = lihatDetailTiketOperator;