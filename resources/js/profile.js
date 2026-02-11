document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const previewImage = document.getElementById('preview');

    if (avatarInput && previewImage) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                    // Berikan efek transisi
                    previewImage.classList.add('opacity-50');
                    setTimeout(() => previewImage.classList.remove('opacity-50'), 150);
                }
                reader.readAsDataURL(file);
            }
        });
    }
});