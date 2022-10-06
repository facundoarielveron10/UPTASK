// Seleccionamos el boton, el sidebar y el body
const mobileMenuBtn = document.querySelector('#mobile-menu');
const sidebar = document.querySelector('.sidebar');
const body = document.querySelector('body');

// Si el boton existe creamos el menu
if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function () {
        if (sidebar.classList.contains('mostrar')) {
            sidebar.classList.add('ocultar');
            setTimeout(() => {
                sidebar.classList.remove('mostrar');
                sidebar.classList.remove(('ocultar'));
            }, 500);
        } else {
            sidebar.classList.add("mostrar");
            sidebar.classList.remove('ocultar');
        }
        body.classList.toggle('overflow-hidden')
    });
}