// Seleccionamos el boton, el sidebar y el body
const mobileMenuBtn = document.querySelector('#mobile-menu');
const sidebar = document.querySelector('.sidebar');
const body = document.querySelector('body');

// Si el boton existe creamos el menu
if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function () {
        sidebar.classList.toggle('mostrar');
        body.classList.toggle('overflow-hidden')
    });
}