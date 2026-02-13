window.goToStep = function(stepNumber, category = null) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));

    const targetStep = document.getElementById('step-' + stepNumber);
    if(targetStep) targetStep.classList.remove('hidden');

    if (stepNumber === 2 && category) {
        document.querySelectorAll('.form-section').forEach(el => el.classList.add('hidden'));

        const inputKategori = document.getElementById('kategori_aktif');
        if (inputKategori) {
            inputKategori.value = category;
        }

        if (category === 'asn') {
            const formAsn = document.getElementById('form-asn');
            if(formAsn) formAsn.classList.remove('hidden');
        } else if (category === 'perangkat_daerah') {
            const formPD = document.getElementById('form-perangkat-daerah');
            if(formPD) formPD.classList.remove('hidden');
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

window.toggleOpsiAkun = function() {
    const containerAlasan = document.getElementById('field-alasan');
    const containerUsulan = document.getElementById('field-usulan-nama');

    const radioHapus = document.getElementById('opsi-hapus');
    const radioGanti = document.getElementById('opsi-ganti');

    const pilihHapus = radioHapus ? radioHapus.checked : false;
    const pilihGanti = radioGanti ? radioGanti.checked : false;

    if (containerAlasan) {
        if (pilihHapus || pilihGanti) {
            containerAlasan.classList.remove('hidden');
        } else {
            containerAlasan.classList.add('hidden');
        }
    }

    if (containerUsulan) {
        if (pilihGanti) {
            containerUsulan.classList.remove('hidden');
        } else {
            containerUsulan.classList.add('hidden');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-pengajuan');
    
    if(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const btnSubmit = e.submitter || this.querySelector('button[type="submit"]');
            const originalBtnText = btnSubmit.innerHTML;
            
            resetValidationErrors();
            const alertError = document.getElementById('alert-error');
            if(alertError) alertError.classList.add('hidden');
            
            btnSubmit.innerHTML = '<span class="animate-spin">↻</span> Memproses...';
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
                if (data.status === 'success') {
                    goToStep(3); 
                    
                    if(data.uuid) {
                        window.location.href = `/services/email-gov/download/${data.uuid}`;
                    }
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

    function resetValidationErrors() {
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
        document.querySelectorAll('.text-red-500').forEach(el => el.remove());
    }

    function showValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const input = document.querySelector(`[name="${field}"]`);
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