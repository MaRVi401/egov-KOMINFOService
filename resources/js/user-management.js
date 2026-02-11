import Swal from 'sweetalert2';

window.confirmDelete = function (uuid, userName) {
    Swal.fire({
        title: 'Konfirmasi Hapus User',
        html: `Apakah Anda yakin? Data <b>${userName}</b> akan dihapus secara permanen dari MinIO dan Database.<br><br>Ketik nama user di bawah untuk konfirmasi:`,
        input: 'text',
        placeholder: 'Ketik nama lengkap user...',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Hapus Data',
        confirmButtonColor: '#d33',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: (inputName) => {
            if (inputName !== userName) {
                Swal.showValidationMessage(`Nama yang Anda masukkan salah! (Harus: ${userName})`);
                return false;
            }
            return true;
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + uuid).submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('simple-search');
    const clearBtn = document.querySelector('[title="Bersihkan Pencarian"]');

    if (searchInput && clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            searchInput.value = ''; 
        });
    }
});

window.previewImage = function(input) {
    const preview = document.getElementById('avatar-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}