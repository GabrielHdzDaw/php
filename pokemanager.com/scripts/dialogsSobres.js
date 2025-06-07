const dialogoSobre = document.getElementById("dialogoSobre");
const cerrarDialogoSobre = document.getElementById("cerrarDialogoSobre");

const sobresFormulario = document.querySelectorAll(".sobres-formulario");

sobresFormulario.forEach((formulario) => {
    formulario.addEventListener("submit", (e) => {
        e.preventDefault();

        const form = e.target;
        const divSobre = form.closest('.sobre');

        if (divSobre) {
            divSobre.classList.add('animacion-sobre');

            setTimeout(() => {
                divSobre.classList.remove('animacion-sobre');
                form.submit();
            }, 2500);
        }
    });
});

// Tuve muchos problemas con el dialogo de sobre. Esto es lo que se me propuso para que funcione correctamente.
//  Se guarda en sessionStorage si el dialogo se ha cerrado para que no se vuelva a abrir al recargar la pagina.
if (dialogoSobre) {
    if (!sessionStorage.getItem('dialogoSobreCerrado')) {
        dialogoSobre.classList.add("blur-inverso");
        dialogoSobre.showModal();
        document.body.classList.add("blur");
        document.body.style.overflow = "hidden";
    }


    cerrarDialogoSobre?.addEventListener("click", () => {
        dialogoSobre.classList.remove("blur-inverso");
        dialogoSobre.style.display = "none";
        dialogoSobre.close();
        document.body.classList.remove("blur");
        document.body.style.overflow = "";
        sessionStorage.setItem('dialogoSobreCerrado', 'true');
    });


    dialogoSobre.addEventListener("cancel", (e) => {
        e.preventDefault();
        dialogoSobre.close();
        document.body.classList.remove("blur");
        document.body.style.overflow = "";
        sessionStorage.setItem('dialogoSobreCerrado', 'true');
    });
}

window.addEventListener('beforeunload', () => {
    sessionStorage.removeItem('dialogoSobreCerrado');
});