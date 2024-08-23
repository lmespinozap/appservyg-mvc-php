document.addEventListener('DOMContentLoaded', function() {
    // Código aquí
    iniciarApp();
});

function iniciarApp () {
    buscarPorFecha();
}

function buscarPorFecha() {
    const fechaInput = document.querySelector('#dateCita');
    fechaInput.addEventListener('input', function(e) {
        const fechaSeleccionada = e.target.value;

        window.location = `?fecha=${fechaSeleccionada}`;
    });
}