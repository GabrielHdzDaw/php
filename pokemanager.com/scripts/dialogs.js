const botonRegistro = document.getElementById("botonRegistro");
const dialogoRegistro = document.getElementById("dialogoRegistro");
const botonCerrarRegistro = document.getElementById("botonCerrarRegistro");

botonRegistro.addEventListener("click", () => {
    dialogoRegistro.showModal();
});

botonCerrarRegistro.addEventListener("click", () => {
    dialogoRegistro.close();
});

