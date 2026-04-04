const formInicio = document.getElementById("form-inicio");
const formCrear = document.getElementById("form-crear");
const btnIrCrear = document.getElementById("btn-ir-crear");
const btnVolverInicio = document.getElementById("btn-volver-inicio");

btnIrCrear.addEventListener("click", () => {
    formInicio.classList.add("oculto");
    formCrear.classList.remove("oculto");
});

btnVolverInicio.addEventListener("click", () => {
    formCrear.classList.add("oculto");
    formInicio.classList.remove("oculto");
});
