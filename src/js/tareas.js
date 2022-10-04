( function() {
    // Nos traemos las tareas
    obtenerTareas();
    let tareas = [];

    // Boton para mostrar el Formulario de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    // Trae todas las tareas asociadas al proyecto indicado
    async function obtenerTareas() {
        try {
            // Guardamos el id de la url
            const id = obtenerProyecto();
            // Generamos la url con el id del proyecto
            const url = `/api/tareas?id=${id}`
            // Pedimos las tareas asociados a el id del proyecto
            const respuesta = await fetch(url);
            // Nos traemos las tareas
            const resultado = await respuesta.json();

            // Las Tareas
            tareas = resultado.tareas;
            // Mostramos las tareas
            mostrarTareas();

        } catch (error) {
            console.log(error);
        }
    }

    // Muestra las tareas
    function mostrarTareas() {
        // Limpiamos el HTML
        limpiarTareas();
        // Seleccionamos del UL del DOM
        const contenedorTareas = document.querySelector('#listado-tareas');
        // Si todavia no se creo ninguna tarea
        if (tareas.length === 0) {
            // Creamos la los LI para mostrar el texto
            const textoNoTareas = document.createElement('LI');
            // Agregamos al LI el texto de "NO HAY TAREAS AUN"
            textoNoTareas.textContent = "No Hay Tareas Aún";
            // Le agregamos una clase para darle estilos
            textoNoTareas.classList.add("no-tareas");
            // Lo mostramos en el DOM
            contenedorTareas.appendChild(textoNoTareas);
            return;
        }

        // Creamos los estados para saber cuando una tarea esta Pendiente o Completa
        const estados = {
            0: 'Pendiente',
            1: 'Completa'
        }
        // Hay Tareas para mostrar, entonces las mostramos
        tareas.forEach(tarea => {
            //-- CREAR --//
            // Creamos la los LI para mostrar las tareas
            const contenedorTareas = document.createElement('LI');
            // Creamos un parrafo para el nombre de la tarea
            const nombreTarea = document.createElement('P');
            // Creamos un contendor para las opciones de la tarea
            const opciones = document.createElement('DIV');
            // Creamos un boton para el estado de la tarea (PENDIENTE, COMPLETA)
            const botonEstadoTarea = document.createElement('BUTTON');
            // Creamos un boton para eliminar una tarea
            const botonEliminarTarea = document.createElement('BUTTON');
            
            //-- AGREGAR --//
            //- LI -// (Tareas)
            contenedorTareas.dataset.tareaId = tarea.id;
            contenedorTareas.classList.add("tarea");
            //- P -// (Nombre de la tarea)
            nombreTarea.textContent = tarea.nombre;
            //- DIV -// (Opciones)
            opciones.classList.add('opciones');
            //- BUTTON -// (Botones)
            // ESTADOS // 
            botonEstadoTarea.classList.add('estado-tarea');
            botonEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`)
            botonEstadoTarea.dataset.estadoTarea = tarea.estado;
            botonEstadoTarea.textContent = estados[tarea.estado];
            // ELIMINAR //
            botonEliminarTarea.classList.add('eliminar-tarea');
            botonEliminarTarea.dataset.idTarea = tarea.id;
            botonEliminarTarea.textContent = 'Eliminar';
            
            //-- AGRUPAR --//
            //- DIV -// (Opciones de las tareas)
            // Agrupamos el boton de estados de las tareas con las opciones
            opciones.appendChild(botonEstadoTarea);
            // Agrupamos el boton de eliminar tareas con las opciones
            opciones.appendChild(botonEliminarTarea);
            //- LI -// (Lista de Tareas)
            // Agrupamos el nombre de las tareas con la lista
            contenedorTareas.appendChild(nombreTarea);
            // Agrupamos las opciones con la lista
            contenedorTareas.appendChild(opciones);
            
            //-- MOSTRAR --//
            // Mostramos todo en pantalla
            const listaTareas = document.querySelector('#listado-tareas');
            listaTareas.appendChild(contenedorTareas);
        });
    }

    // Muestra el formulario del nueva tarea
    function mostrarFormulario() {
        // Seleccionamos todo el Body
        const body = document.querySelector('.body');
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
            body.classList.add('overflow-hidden');
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
                body.classList.remove('overflow-hidden')

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
        // Seleccionamos todo el Body
        const body = document.querySelector('.body');
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
            
            // Guardamos los datos de la peticion
            const resultado = await respuesta.json();
            
            // Mostrar una alerta
            mostrarAlerta(resultado.tipo, resultado.mensaje, document.querySelector('.formulario legend'));

            // Cerramos el modal
            if (resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');
                body.classList.remove('overflow-hidden')
                setTimeout(() => {
                    modal.remove();
                }, 3000);

                // Agregar al objeto de tarea al global de tareas
                const tareasObj = {
                    id: String(resultado.id),
                    nombre: tarea,
                    estado: '0',
                    proyectoId: resultado.proyectoId
                }
                // Creamos una copia y la reescribimos con la nueva (tareasObj)
                tareas = [...tareas, tareasObj];
                mostrarTareas();
            }

        } catch (error) {
            console.log(error);
        }
    }

    // Optiene todos los proyectos relacionados al usurio
    function obtenerProyecto() {
        // Leemos la url para saber que proyecto tenemos que agregar la tarea
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }

    // Limpia todo el DOM para actualizar las tareas
    function limpiarTareas() {
        const listadoTareas = document.querySelector('#listado-tareas');
        while (listadoTareas.firstChild) {
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }

})();