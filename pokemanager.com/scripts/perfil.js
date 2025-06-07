document.addEventListener('DOMContentLoaded', function () {
    const btnGuardar = document.getElementById('btn-guardar');
    let hasChanges = false;

    document.querySelectorAll('[contenteditable]').forEach(element => {
        element.addEventListener('input', function () {
            if (!hasChanges) {
                hasChanges = true;
                btnGuardar.style.display = 'block';
            }
        });
    });

    document.getElementById('foto-input').addEventListener('change', function (e) {
        if (e.target.files[0]) {
            const file = e.target.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!validTypes.includes(file.type)) {
                alert('Solo se permiten imágenes JPEG, PNG, GIF o WebP');
                return;
            }

            if (file.size > maxSize) {
                alert('La imagen no puede superar los 5MB');
                return;
            }

            const reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById('preview-foto').src = event.target.result;
                if (!hasChanges) {
                    hasChanges = true;
                    btnGuardar.style.display = 'block';
                }
            };
            reader.readAsDataURL(file);
        }
    });

    btnGuardar.addEventListener('click', function () {
        const formData = new FormData();
        formData.append('nombre', document.getElementById('editable-nombre').innerText.trim());
        formData.append('email', document.getElementById('editable-email').innerText.trim());

        const fileInput = document.getElementById('foto-input');
        if (fileInput.files[0]) {
            formData.append('ruta_foto_perfil', fileInput.files[0]);
        }

        btnGuardar.disabled = true;
        btnGuardar.textContent = 'Guardando...';

        fetch('includes/guardar_perfil.inc.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.status === 204) {
                    alert('Cambios guardados correctamente');
                    location.reload();
                } else if (response.status === 422) {
                    alert('Datos inválidos');
                } else if (response.status === 415) {
                    alert('Tipo de archivo no permitido');
                } else if (response.status === 400) {
                    alert('No se realizaron cambios');
                } else if (response.status === 401) {
                    alert('No autorizado');
                } else if (response.status === 500) {
                    alert('Error del servidor');
                } else {
                    alert('Error inesperado (código ' + response.status + ')');
                }
            })
            .catch(error => {
                alert('Error de conexión');
            })
            .finally(() => {
                btnGuardar.disabled = false;
                btnGuardar.textContent = 'Guardar';
            });
    });
});