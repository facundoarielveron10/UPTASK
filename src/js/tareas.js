( function() {
    // Boton para mostrar el Formulario de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    // Muestra el formulario del nueva tarea
    function mostrarFormulario() {
        // Creamos el modal
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML =`
            <!-- Formulario -->
            <form class="formulario nueva-tarea">
                <legend>Añade una nueva tarea</legend>
                <!-- Tarea -->
                <div class="campo">
                    <input
                        type="text"
                        name="tarea"
                        placeholder="Añadir Tarea al Proyecto Actual"
                        id="tarea"
                    />
                </div>
                <!-- Opciones -->
                <div class="opciones">
                    <input 
                        type="submit" 
                        class="submit-nueva-tarea" 
                        value="Añadir Tarea"
                    />
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
        `;

        // Animacion al aparecer el modal
        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);
        
        // Registramos todos los elementos del modal
        modal.addEventListener('click', function (e) {
            e.preventDefault();
            // Si es el boton de cerrar
            if (e.target.classList.contains('cerrar-modal')) {
                // Animacion al cerrar el modal
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');
                
                // Eliminamos el modal
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
            if (e.target.classList.contains('submit-nueva-tarea')) {
                submitFormularioNuevaTarea();
            }
        });

        document.querySelector('.dashboard').appendChild(modal);
    }

    // Crea una nueva tarea
    function submitFormularioNuevaTarea() {
        // Seleccionamos el nombre que el usuario le puso a la tarea
        const tarea = document.querySelector('#tarea').value.trim();
        // Si el nombre de la tarea esta vacio
        if (tarea === '') {
            // Mostrar una alerta de error
            mostrarAlerta('error', 'El nombre de la tarea es Obligatorio', document.querySelector('.formulario legend'));

            return;
        }
        // Consultar el Servidor para añador una nueva tarea al proyecto
        agregarTarea(tarea);
    }
    
    // Muestra una alerta en la interfaz
    function mostrarAlerta(tipo, mensaje, referencia) {
        // Previene la creacion de multiples alertas
        const alertaPrevia = document.querySelector('.alerta');
        if (alertaPrevia) {
            alertaPrevia.remove();
        }

        // Creamos una alerta
        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;

        // La agregamos a la interfaz
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);
    
        // Eliminar la alerta despues de 5 segundos
        setTimeout(() => {
            alerta.remove();
        }, 5000);
    }

    // Agrega la tarea al proyecto
    async function agregarTarea(tarea) {
        // Construcir la peticion
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoId', obtenerProyecto());

        

        try {
            // Enviamos la peticion
            const url = 'http://localhost:3000/api/tarea';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
            console.log(resultado);

        } catch (error) {
            console.log(error);
        }
    }

    function obtenerProyecto() {
        // Leemos la url para saber que proyecto tenemos que agregar la tarea
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }

})();