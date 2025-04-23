const dialogoSobre = document.getElementById("dialogoSobre");
const cerrarDialogoSobre = document.getElementById("cerrarDialogoSobre");

// Verificar si el modal existe en la página
if (dialogoSobre) {
    // Mostrar solo si no está cerrado en sessionStorage
    if (!sessionStorage.getItem('dialogoSobreCerrado')) {
        dialogoSobre.classList.add("blur-inverso");
        dialogoSobre.showModal();
        document.body.classList.add("blur");
        document.body.style.overflow = "hidden";
    }

    // Cerrar con el botón
    cerrarDialogoSobre?.addEventListener("click", () => {
        dialogoSobre.classList.remove("blur-inverso");
        dialogoSobre.style.display = "none"; // Oculta el diálogo
        dialogoSobre.close();
        document.body.classList.remove("blur");
        document.body.style.overflow = "";
        sessionStorage.setItem('dialogoSobreCerrado', 'true');
    });

    // Cerrar con ESC
    dialogoSobre.addEventListener("cancel", (e) => {
        e.preventDefault();
        dialogoSobre.close();
        document.body.classList.remove("blur");
        document.body.style.overflow = "";
        sessionStorage.setItem('dialogoSobreCerrado', 'true');
    });
}

// Limpiar sessionStorage al salir de la página
window.addEventListener('beforeunload', () => {
    sessionStorage.removeItem('dialogoSobreCerrado');
});