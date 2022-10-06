// Seleccionamos el boton y el sidebar
const mobileMenuBtn = document.querySelector('#mobile-menu');
const sidebar = document.querySelector('.sidebar');

// Si el boton existe creamos el menu
if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function () {
        sidebar.classList.toggle('mostrar');
    });
}