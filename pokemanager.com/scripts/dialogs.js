const botonRegistro = document.getElementById("botonRegistro");
const dialogoRegistro = document.getElementById("dialogoRegistro");
const botonCerrarRegistro = document.getElementById("botonCerrarRegistro");

const dialogoSobre = document.getElementById("dialogoSobre");

const cerrarDialogoSobre = document.getElementById("cerrarDialogoSobre");

botonRegistro.addEventListener("click", () => {
    document.body.classList.add("modal-abierto", "blur");
    dialogoRegistro.classList.add("blur-inverso");
    dialogoRegistro.showModal();
    
    document.body.style.overflow = "hidden"; // Desactiva el scroll del body
});

botonCerrarRegistro.addEventListener("click", () => {
    document.body.classList.remove("modal-abierto", "blur");
    dialogoRegistro.close();
    dialogoRegistro.classList.remove("blur-inverso");
    document.body.classList.add("blur-inverso-body");

    document.body.style.overflow = ""; // Reactiva el scroll del body
});

document.addEventListener("DOMContentLoaded", () => {
    dialogoSobre.showModal();
    dialogoSobre.classList.add("blur-inverso");
    document.body.classList.add("blur");
    document.body.style.overflow = "hidden"; // Desactiva el scroll del body
});

// dialogoSobre.addEventListener("cancel", () => {
//     document.body.classList.remove("blur");
//     dialogoSobre.close();
//     document.body.classList.remove("blur-inverso-body");
//     document.body.style.overflow = ""; // Reactiva el scroll del body
// });

cerrarDialogoSobre.addEventListener("click", () => {
    document.body.classList.remove("blur");
    dialogoSobre.close();
    document.body.classList.remove("blur-inverso-body");
    document.body.style.overflow = ""; // Reactiva el scroll del body
});