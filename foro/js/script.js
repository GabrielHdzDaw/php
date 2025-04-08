
const formularioModificarDatos = document.querySelector(".formulario-modificar-datos");
const dialogoActualizarDatos = document.querySelector("#dialogoActualizarDatos");
const botonActualizarDatos = document.querySelector("#botonActualizarDatos");

const formularioborrarUsuario = document.querySelector(".formulario-borrar-usuario");
const dialogoBorrarUsuario = document.querySelector("#dialogoBorrarUsuario");
const botonBorrarUsuario = document.querySelector("#botonBorrarUsuario");

const formularioCrearHilo = document.querySelector(".formulario-crear-hilo");
const dialogoCrearHilo = document.querySelector("#dialogoNuevoHilo");
const botonCrearHilo = document.querySelector("#botonCrearHilo");
botonCrearHilo.addEventListener("click", (e) => {
    dialogoCrearHilo.showModal();
    if (e.target.matches(".cerrar-dialogo")) {
        dialogoCrearHilo.close();
    }
});

botonActualizarDatos.addEventListener("click", (e) => {
    dialogoActualizarDatos.showModal();
    if (e.target.matches(".cerrar-dialogo")) {
        dialogoActualizarDatos.close();
    }
});

botonBorrarUsuario.addEventListener("click", (e) => {
    dialogoBorrarUsuario.showModal();
    if (e.target.matches(".cerrar-dialogo")) {
        dialogoBorrarUsuario.close();
    }
});

