document.addEventListener('DOMContentLoaded', () => {
    const editarBtns = document.querySelectorAll('.btn-editar-usuario');
    const guardarBtns = document.querySelectorAll('.btn-guardar-usuario');
    const cancelarBtns = document.querySelectorAll('.btn-cancelar-edicion');

    editarBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const fila = btn.closest('tr');
            const celdasEditables = fila.querySelectorAll('td:nth-child(n+4):nth-child(-n+9)');

            celdasEditables.forEach(td => {
                td.setAttribute('contenteditable', 'true');
                td.dataset.original = td.innerText.trim();
                td.classList.add('editable-activa');
            });

            btn.style.display = 'none';
            fila.querySelector('.btn-guardar-usuario').style.display = 'inline-block';
            fila.querySelector('.btn-cancelar-edicion').style.display = 'inline-block';
        });
    });

    guardarBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const fila = btn.closest('tr');
            const id = btn.dataset.id;
            const celdas = fila.querySelectorAll('td');

            const datos = {
                id: id,
                nombre: celdas[3].innerText.trim(),
                email: celdas[4].innerText.trim(),
                fecha_nacimiento: celdas[5].innerText.trim(),
                creado: celdas[6].innerText.trim(),
                ultimo_login: celdas[7].innerText.trim(),
                sobres: celdas[8].innerText.trim()
            };

            fetch('includes/admin/editar_usuario.inc.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            })
                .then(res => res.text())
                .then(response => {
                    location.reload();
                });
        });
    });

    cancelarBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const fila = btn.closest('tr');
            const celdas = fila.querySelectorAll('td:nth-child(n+4):nth-child(-n+9)');

            celdas.forEach(td => {
                td.innerText = td.dataset.original;
                td.removeAttribute('contenteditable');
                td.classList.remove('editable-activa');
            });

            fila.querySelector('.btn-editar-usuario').style.display = 'inline-block';
            fila.querySelector('.btn-guardar-usuario').style.display = 'none';
            fila.querySelector('.btn-cancelar-edicion').style.display = 'none';
        });
    });
    document.querySelectorAll('.btn-toggle-admin').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const estadoActual = parseInt(btn.dataset.estado);
            const nuevoEstado = estadoActual === 1 ? 0 : 1;

            fetch('includes/admin/toggle_admin.inc.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id, is_admin: nuevoEstado })
            })
                .then(res => res.text())
                .then(response => {
                    btn.dataset.estado = nuevoEstado;
                    btn.textContent = nuevoEstado === 1 ? 'Sí' : 'No';
                    btn.classList.remove('admin-si', 'admin-no');
                    btn.classList.add(nuevoEstado === 1 ? 'admin-si' : 'admin-no');
                });
        });
    });
});
