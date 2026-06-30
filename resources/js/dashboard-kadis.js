document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('usulanDonutChart');
    if (ctx) {
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

window.bukaModalReview = function (btn) {
    const modal = document.getElementById('modalReviewKadis');
    const uuid = btn.getAttribute('data-uuid');
    const noTiket = btn.getAttribute('data-notiket');
    const layanan = btn.getAttribute('data-layanan');
    const pengusul = btn.getAttribute('data-pengusul');
    const catatanKabid = btn.getAttribute('data-catatankabid');
    const deskripsi = btn.getAttribute('data-deskripsi');

    // Ambil kedua atribut
    const lampiran = btn.getAttribute('data-lampiran');
    const suratPengantar = btn.getAttribute('data-suratpengantar');

    document.getElementById('rev-notiket').innerText = noTiket;
    document.getElementById('rev-layanan').innerText = layanan;
    document.getElementById('rev-pengusul').innerText = "- " + pengusul;
    document.getElementById('rev-catatankabid').innerText = catatanKabid;
    document.getElementById('rev-deskripsi').innerText = deskripsi;

    // Inisialisasi Elemen Tombol
    const btnLampiran = document.getElementById('rev-lampiran');
    const btnSuratPengantar = document.getElementById('rev-suratpengantar');
    const txtNoLampiran = document.getElementById('rev-nolampiran');

    // Reset tampilan awal (sembunyikan semua)
    btnLampiran.classList.add('hidden');
    btnSuratPengantar.classList.add('hidden');
    txtNoLampiran.classList.add('hidden');

    let adaLampiran = false;

    // Cek dan tampilkan Lampiran Utama
    if (lampiran && lampiran.trim() !== '') {
        btnLampiran.href = lampiran;
        btnLampiran.classList.remove('hidden');
        adaLampiran = true;
    }

    // Cek dan tampilkan Surat Pengantar Kadis
    if (suratPengantar && suratPengantar.trim() !== '') {
        btnSuratPengantar.href = suratPengantar;
        btnSuratPengantar.classList.remove('hidden');
        adaLampiran = true;
    }

    // Jika keduanya kosong, munculkan teks "Tidak ada lampiran"
    if (!adaLampiran) {
        txtNoLampiran.classList.remove('hidden');
    }

    // (Sisa kode untuk action form URL tetap sama...)
    const form = document.getElementById('formReviewKadis');
    const baseUrl = form.getAttribute('data-action-url');
    const updatedUrl = baseUrl.replace('%3Auuid', uuid).replace(':uuid', uuid);
    form.setAttribute('action', updatedUrl);
    form.action = updatedUrl;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
};

window.tutupModalReview = function () {
    const modal = document.getElementById('modalReviewKadis');
    const form = document.getElementById('formReviewKadis');


    modal.classList.remove('flex');
    modal.classList.add('hidden');

    document.body.style.overflow = 'auto';
    form.reset();
};

document.addEventListener('DOMContentLoaded', function () {
    const formReview = document.getElementById('formReviewKadis');

    if (formReview) {
        formReview.addEventListener('submit', async function (e) {
            e.preventDefault();

            let form = this;
            let url = form.action;
            let formData = new FormData(form);

            let submitBtn = form.querySelector('button[type="submit"]');
            let originalBtnText = submitBtn.innerHTML;

            Swal.fire({
                title: 'Menyimpan Data...',
                html: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            submitBtn.disabled = true;

            try {
                let response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    let errorData = await response.json().catch(() => null);
                    throw new Error(errorData ? (errorData.message || JSON.stringify(errorData.errors)) : `HTTP Error: ${response.status}`);
                }

                let result = await response.json();

                Swal.fire({
                    title: 'Berhasil!',
                    text: result.message,
                    icon: 'success',
                    confirmButtonColor: '#2563eb',
                }).then(() => {
                    tutupModalReview();
                    window.location.reload();
                });

            } catch (error) {
                console.error(error);

                Swal.fire({
                    title: 'Gagal Menyimpan!',
                    text: error.message || 'Terjadi kesalahan pada jaringan atau server.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                });
            } finally {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            }
        });
    }
});