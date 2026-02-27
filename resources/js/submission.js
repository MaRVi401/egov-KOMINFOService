import Swal from 'sweetalert2';

window.previewUpload = function (input) {
    const previewContainer = document.getElementById('file-preview-container');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileType = file.type;
        const reader = new FileReader();

        reader.onload = function (e) {
            if (previewContainer) {
                if (fileType.startsWith('image/')) {
                    previewContainer.innerHTML = `<img src="${e.target.result}" class="w-full max-w-md rounded-lg border border-gray-200 shadow-sm" alt="Preview Surat" />`;
                } 
                else if (fileType === 'application/pdf') {
                    previewContainer.innerHTML = `
                        <div class="flex items-center p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9 13a1 1 0 1 1 2 0v-5a1 1 0 1 1-2 0v5Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">File PDF Terpilih:</span> ${file.name}
                            </div>
                        </div>`;
                }
            }
        }
        reader.readAsDataURL(file);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('simple-search');
    const clearBtn = document.querySelector('[title="Bersihkan Pencarian"]');

    if (searchInput && clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            if (clearBtn.tagName !== 'A') {
                searchInput.value = '';
            }
        });
    }

    // Logic untuk konfirmasi tombol hapus dengan SweetAlert2
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Cegah button submit form otomatis
            const form = this.closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pengajuan tiket ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});