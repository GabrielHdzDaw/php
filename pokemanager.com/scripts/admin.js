document.addEventListener('DOMContentLoaded', () => {
    const btnEliminarUsuario = document.querySelectorAll('.btn-eliminar-usuario');
    const btnBorrarSobres = document.querySelectorAll('.btn-borrar-sobres');
    const btnAnadirSobres = document.querySelectorAll('.btn-anadir-sobres');
    const btnBorrarColeccion = document.querySelectorAll('.btn-borrar-coleccion');

    btnEliminarUsuario.forEach(btn => {
        btn.addEventListener('click', () => {
            if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                const id = parseInt(btn.dataset.id);
                fetch(`includes/admin/eliminar_usuario.inc.php?id=${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                        location.reload();
                    });
            }
        });
    });

});