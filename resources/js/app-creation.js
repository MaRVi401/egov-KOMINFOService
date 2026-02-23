window.goToStep = function(stepNumber, category = null) {
    // Sembunyikan semua step
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));

    // Tampilkan step yang dituju
    const targetStep = document.getElementById('step-' + stepNumber);
    if(targetStep) targetStep.classList.remove('hidden');

    // Logika khusus jika masuk ke Step 2 (Pilih Form)
    if (stepNumber === 2 && category) {
        document.querySelectorAll('.form-section').forEach(el => el.classList.add('hidden'));

        const inputKategori = document.getElementById('kategori_aktif');
        if (inputKategori) {
            inputKategori.value = category;
        }

        // Tampilkan form sesuai pilihan card di step 1
        if (category === 'pembangunan_awal') {
            const formAwal = document.getElementById('form-pembangunan-awal');
            if(formAwal) formAwal.classList.remove('hidden');
        } else if (category === 'pengembangan_fitur') {
            const formFitur = document.getElementById('form-pengembangan-fitur');
            if(formFitur) formFitur.classList.remove('hidden');
        }
    }

    updateStepper(stepNumber);
}

window.updateStepper = function(activeStep) {
    for (let i = 1; i <= 3; i++) {
        let indicator = document.getElementById('indicator-step-' + i);
        if(!indicator) continue;
        
        let circle = indicator.querySelector('span:first-child');
        
        if (i === activeStep) {
            indicator.className = "flex items-center space-x-2.5 text-blue-600 dark:text-blue-500";
            circle.className = "flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500 bg-white dark:bg-gray-800";
        } else if (i < activeStep) {
            indicator.className = "flex items-center space-x-2.5 text-gray-900 dark:text-gray-300";
            circle.className = "flex items-center justify-center w-8 h-8 border border-gray-900 rounded-full shrink-0 dark:border-gray-300 bg-gray-100 dark:bg-gray-700";
        } else {
            indicator.className = "flex items-center space-x-2.5 text-gray-500 dark:text-gray-400";
            circle.className = "flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400 bg-white dark:bg-gray-800";
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // 1. LOGIKA FITUR DINAMIS (TAMBAH/HAPUS MULTIPLE FORM)
    // ==========================================
    const fiturContainers = document.querySelectorAll('.fitur-container');
    const maxFitur = 20;

    fiturContainers.forEach(container => {
        // Ambil nama input dari atribut data-name (ajuan_fitur[] atau kembang_nama_fitur[])
        const inputName = container.getAttribute('data-name'); 

        function updateButtons() {
            const rows = container.querySelectorAll('.fitur-row');
            const count = rows.length;

            rows.forEach((row, index) => {
                const btnTambah = row.querySelector('.btn-tambah-fitur');
                const btnHapus = row.querySelector('.btn-hapus-fitur');

                if (count >= maxFitur) {
                    if (btnTambah) btnTambah.classList.add('hidden');
                } else {
                    if (index === 0 || index === count - 1) {
                        if (btnTambah) btnTambah.classList.remove('hidden');
                    } else {
                        if (btnTambah) btnTambah.classList.add('hidden');
                    }
                }

                if (index === 0) {
                    if (btnHapus) btnHapus.classList.add('hidden');
                } else {
                    if (btnHapus) btnHapus.classList.remove('hidden');
                }
            });

            // Tampilkan atau sembunyikan teks peringatan
            const warningTxt = container.parentElement.querySelector('.fitur-warning');
            if (warningTxt) {
                if (count >= maxFitur) {
                    warningTxt.classList.remove('hidden');
                } else {
                    warningTxt.classList.add('hidden');
                }
            }
        }

        container.addEventListener('click', function(e) {
            const btnTambah = e.target.closest('.btn-tambah-fitur');
            const btnHapus = e.target.closest('.btn-hapus-fitur');

            if (btnTambah) {
                const currentRows = container.querySelectorAll('.fitur-row').length;
                if (currentRows >= maxFitur) return;

                const newRow = document.createElement('div');
                newRow.className = 'flex items-center space-x-2 transition-all duration-300 fitur-row';
                
                // Tema tombol mengikuti form mana ini dipanggil (Biru untuk Awal, Hijau untuk Kembang)
                const btnColor = inputName.includes('kembang') ? 'green' : 'blue';

                newRow.innerHTML = `
                    <input type="text" name="${inputName}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-${btnColor}-500 focus:border-${btnColor}-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Fitur ke-${currentRows + 1}...">
                    
                    <button type="button" class="btn-tambah-fitur px-3 py-2.5 text-sm font-medium text-white bg-${btnColor}-600 rounded-lg hover:bg-${btnColor}-700 focus:ring-4 focus:outline-none focus:ring-${btnColor}-300 dark:bg-${btnColor}-600 dark:hover:bg-${btnColor}-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </button>

                    <button type="button" class="btn-hapus-fitur px-3 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                    </button>
                `;
                
                container.appendChild(newRow);
                updateButtons();
            }

            if (btnHapus) {
                const rowToDel = btnHapus.closest('.fitur-row');
                if (rowToDel) {
                    rowToDel.remove();
                    
                    const remainingRows = container.querySelectorAll('.fitur-row');
                    remainingRows.forEach((row, idx) => {
                        const input = row.querySelector('input');
                        if (input) input.placeholder = `Fitur ke-${idx + 1}...`;
                    });

                    updateButtons();
                }
            }
        });

        updateButtons();
    });

    // ==========================================
    // 2. LOGIKA FORM SUBMIT (AJAX)
    // ==========================================
    const form = document.getElementById('form-pengajuan');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            // Ambil tombol yang di-klik
            const btnSubmit = e.submitter || this.querySelector('button[type="submit"]');
            const originalBtnText = btnSubmit.innerHTML;
            
            resetValidationErrors();
            
            const alertError = document.getElementById('alert-error');
            if(alertError) alertError.classList.add('hidden');
            
            // Loading state
            btnSubmit.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Memproses...';
            btnSubmit.disabled = true;

            let formData = new FormData(this);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                let data;
                try {
                    data = await response.json();
                } catch (err) {
                    throw new Error("Server tidak merespon dengan JSON valid.");
                }

                if (!response.ok) {
                    const error = new Error(data.message || 'Terjadi kesalahan.');
                    error.status = response.status;
                    error.data = data;
                    throw error;
                }

                return data;
            })
            .then(data => {
                // 1. Pindahkan antarmuka ke Langkah 3 (Selesai)
                goToStep(3); 
                
                // 2. Picu pengunduhan dokumen secara otomatis di latar belakang
                if (data.uuid) {
                    const downloadUrl = `/service-app-creation/download/${data.uuid}`;
                    
                    // Membuat elemen tautan tak kasat mata untuk memaksa peramban mengunduh
                    const autoDownloadLink = document.createElement('a');
                    autoDownloadLink.href = downloadUrl;
                    autoDownloadLink.style.display = 'none';
                    document.body.appendChild(autoDownloadLink);
                    
                    // Eksekusi klik otomatis
                    autoDownloadLink.click();
                    
                    // Bersihkan elemen setelah diklik
                    setTimeout(() => {
                        document.body.removeChild(autoDownloadLink);
                    }, 1000);
                }
            })
            .catch(error => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalBtnText;

                if (error.status === 422) {
                    showAlert('Mohon periksa kembali inputan form Anda yang bertanda merah.', 'red');
                    if(error.data && error.data.errors) {
                        showValidationErrors(error.data.errors);
                    }
                } else if (error.status === 500) {
                    showAlert('Terjadi kesalahan pada server. Silakan coba lagi nanti.', 'red');
                } else {
                    showAlert(error.message || 'Gagal menghubungi server.', 'red');
                }
            });
        });
    }

    // ==========================================
    // 3. HELPER FUNCTIONS
    // ==========================================
    function resetValidationErrors() {
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
        document.querySelectorAll('.text-red-500').forEach(el => el.remove());
    }

    function showValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const inputName = field.includes('.') ? field.split('.')[0] + '[]' : field;
            const input = document.querySelector(`[name="${inputName}"]`);
            
            if (input) {
                input.classList.add('border-red-500');
                
                const msgElement = document.createElement('p');
                msgElement.className = 'text-red-500 text-xs mt-1 italic';
                msgElement.innerText = messages[0];
                input.parentElement.appendChild(msgElement);
            }
        }
    }

    function showAlert(message, color) {
        const alertBox = document.getElementById('alert-error');
        const alertText = document.getElementById('alert-error-msg');
        
        if(alertBox && alertText) {
            alertText.innerText = message;
            alertBox.classList.remove('hidden');
            alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            alert(message); 
        }
    }
});