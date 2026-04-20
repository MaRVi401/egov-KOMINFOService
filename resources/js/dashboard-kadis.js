document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('usulanDonutChart');
    if(ctx) {
        const labelsData = JSON.parse(ctx.getAttribute('data-labels'));
        const valuesData = JSON.parse(ctx.getAttribute('data-values'));

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labelsData,
                datasets: [{
                    data: valuesData,
                    backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                cutout: '75%'
            }
        });
    }
});

window.bukaModalReview = function(btn) {
    const modal = document.getElementById('modalReviewKadis');
    const uuid = btn.getAttribute('data-uuid');
    const noTiket = btn.getAttribute('data-notiket');
    const layanan = btn.getAttribute('data-layanan');
    const pengusul = btn.getAttribute('data-pengusul');
    const catatanKabid = btn.getAttribute('data-catatankabid');
    const deskripsi = btn.getAttribute('data-deskripsi');
    const lampiran = btn.getAttribute('data-lampiran');
    
    document.getElementById('rev-notiket').innerText = noTiket;
    document.getElementById('rev-layanan').innerText = layanan;
    document.getElementById('rev-pengusul').innerText = "- " + pengusul;
    document.getElementById('rev-catatankabid').innerText = catatanKabid;
    document.getElementById('rev-deskripsi').innerText = deskripsi;
    
    const btnLampiran = document.getElementById('rev-lampiran');
    const txtNoLampiran = document.getElementById('rev-nolampiran');
    
    if (lampiran && lampiran.trim() !== '') {
        btnLampiran.href = lampiran;
        btnLampiran.classList.remove('hidden');
        txtNoLampiran.classList.add('hidden');
    } else {
        btnLampiran.classList.add('hidden');
        txtNoLampiran.classList.remove('hidden');
    }
    
    const form = document.getElementById('formReviewKadis');
    const baseUrl = form.getAttribute('data-action-url');
    form.action = baseUrl.replace(':uuid', uuid);

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; 
};

window.tutupModalReview = function() {
    const modal = document.getElementById('modalReviewKadis');
    const form = document.getElementById('formReviewKadis');
    
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto'; 
    form.reset(); 
};


document.addEventListener('DOMContentLoaded', function () {
    const formReview = document.getElementById('formReviewKadis');

    if (formReview) {
        formReview.addEventListener('submit', async function (e) {
            // Mencegah halaman reload
            e.preventDefault();

            let form = this;
            let url = form.action;
            let formData = new FormData(form);

            // Opsional: Ubah text tombol jadi "Menyimpan..." biar UX-nya bagus
            let submitBtn = form.querySelector('button[type="submit"]');
            let originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="ti ti-loader animate-spin"></i> Menyimpan...';
            submitBtn.disabled = true;

            try {
                // Kirim request ke server menggunakan Fetch API
                let response = await fetch(url, {
                    method: 'POST', // Biarkan POST, karena _method=PUT sudah ada di FormData bawaan @method('PUT') Blade
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Wajib agar Laravel tahu ini AJAX
                        'Accept': 'application/json'
                    }
                });

                let result = await response.json();

                if (response.ok) {
                    // Notifikasi sukses (bisa diganti pakai SweetAlert kalau kamu pasang)
                    alert('Mantap! ' + result.message);
                    
                    // Tutup modal
                    tutupModalReview();

                    // Opsional: Hilangkan baris tabel yang baru saja disetujui biar nggak perlu reload halaman
                    // Kamu bisa cari baris tr berdasarkan data-uuid tombol yang diklik tadi lalu hapus elemennya dari DOM
                } else {
                    alert('Waduh, gagal menyimpan data.');
                    console.error(result);
                }
            } catch (error) {
                alert('Terjadi kesalahan pada jaringan/server.');
                console.error(error);
            } finally {
                // Kembalikan tombol seperti semula
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            }
        });
    }
});