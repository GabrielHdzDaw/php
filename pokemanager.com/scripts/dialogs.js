const botonRegistro = document.getElementById("botonRegistro");
const dialogoRegistro = document.getElementById("dialogoRegistro");
const botonCerrarRegistro = document.getElementById("botonCerrarRegistro");



botonRegistro.addEventListener("click", () => {
    document.body.classList.add("modal-abierto", "blur");
    dialogoRegistro.classList.add("blur-inverso");
    dialogoRegistro.showModal();
    
    document.body.style.overflow = "hidden";
});

botonCerrarRegistro.addEventListener("click", () => {
    document.body.classList.remove("modal-abierto", "blur");
    dialogoRegistro.close();
    dialogoRegistro.classList.remove("blur-inverso");
    document.body.classList.add("blur-inverso-body");

    document.body.style.overflow = "";
});

