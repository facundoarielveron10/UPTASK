( function() {
    // Nos traemos las tareas
    obtenerTareas();
    let tareas = [];
    let filtradas = [];

    // Boton para mostrar el Formulario de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', function() {
        mostrarFormulario();
    });

    // Filtros de búsqueda
    const filtros = document.querySelectorAll('#filtros input[type="radio"]');
    filtros.forEach( radio => {
        radio.addEventListener('input', filtrarTarea);
    });

    // Filtra las tereas TODAS - COMPLETADAS - PENDIENTES 
    function filtrarTarea(e) {
        // Leemos el filtro elegido
        const filtro = e.target.value;
        // Si el filtro elegido es COMPLETADAS o PENDIENTES
        if (filtro !== '') {
            // Traemos del arreglo de tareas todas las que tienen el estado del filtro elegido
            filtradas = tareas.filter(tarea => tarea.estado === filtro);
        } 
        // SI el filtro elegido es TODAS
        else {
            // Limpiamos el arreglo de filtradas
            filtradas = [];
        }
        
        // Mostramos las tareas filtradas
        mostrarTareas();
    }

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

        // Calculamos cuantas tareas hay PENDIENTES o COMPLETADAS
        totalPendientes();
        totalCompletas();

        // Si filtradas tiene alguna tarea el arrayTareas va a ser igual a las tareas filtradas
        const arrayTareas = filtradas.length ? filtradas : tareas;

        // Seleccionamos del UL del DOM
        const contenedorTareas = document.querySelector('#listado-tareas');
        // Si todavia no se creo ninguna tarea
        if (arrayTareas.length === 0) {
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
        arrayTareas.forEach(tarea => {
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
            nombreTarea.ondblclick = function() {
                mostrarFormulario(true, {...tarea});
            }
            //- DIV -// (Opciones)
            opciones.classList.add('opciones');
            //- BUTTON -// (Botones)
            // ESTADOS // 
            botonEstadoTarea.classList.add('estado-tarea');
            botonEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`)
            botonEstadoTarea.dataset.estadoTarea = tarea.estado;
            botonEstadoTarea.textContent = estados[tarea.estado];
            botonEstadoTarea.ondblclick = function() {
                cambiarEstadoTarea({...tarea});
            }
            // ELIMINAR //
            botonEliminarTarea.classList.add('eliminar-tarea');
            botonEliminarTarea.dataset.idTarea = tarea.id;
            botonEliminarTarea.textContent = 'Eliminar';
            botonEliminarTarea.ondblclick = function() {
                confirmarEliminarTarea({...tarea});
            }
            
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

    // Calcula cuantas tareas hay pendientes
    function totalPendientes() {
        // Nos traemos todas las tareas PENDIENTES
        const totalPendientes = tareas.filter(tarea => tarea.estado === '0');
        // Seleccionamos el input radio de PENDIENTES
        const pendientesRadio = document.querySelector('#pendientes');
        
        // Si no hay tareas PENDIENTES
        if (totalPendientes.length === 0) {
            // Esconde el input radio de PENDIENTES
            pendientesRadio.disabled = true;
        }
        // Si hay tareas PENDIENTES
        else {
            // Muestra el input radio de PENDIENTES
            pendientesRadio.disabled = false;
        }
    }

    // Calcula cuantas tareas hay completas
    function totalCompletas() {
        // Nos traemos todas las teras COMPLETAS
        const totalCompletas = tareas.filter(tarea => tarea.estado === "1");
        // Seleccionamos el input radio de COMPLETADAS
        const completasRadio = document.querySelector('#completadas');

        // Si no hay tareas COMPLETAS
        if (totalCompletas.length === 0) {
            // Esconde el input radio de COMPLETADAS
            completasRadio.disabled = true;
        }
        // Si hay tareas COMPLETADAS
        else {
            // Muestra el input radio de COMPLETADAS
            completasRadio.disabled = false;
        }
    }

    // Muestra el formulario del nueva tarea
    function mostrarFormulario(editar = false, tarea = {}) {
        // Seleccionamos todo el Body
        const body = document.querySelector('.body');
        // Creamos el modal
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML =`
            <!-- Formulario -->
            <form class="formulario nueva-tarea">
                <legend>${editar ? 'Editar Tarea' : 'Añade una nueva tarea'}</legend>
                <!-- Tarea -->
                <div class="campo">
                    <input
                        type="text"
                        name="tarea"
                        placeholder="${tarea.nombre ? 'Editar nombre' : 'Añadir Tarea al Proyecto Actual'}"
                        id="tarea"
                        value="${tarea.nombre ? tarea.nombre : ''}"
                    />
                </div>
                <!-- Opciones -->
                <div class="opciones">
                    <input 
                        type="submit" 
                        class="submit-nueva-tarea" 
                        value="${editar ? 'Guardar Cambios' : 'Añadir tarea'}"
                    />
                    <button type="button" class="cerrar-modal">Cerrar</button>
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
                // Seleccionamos el nombre que el usuario le puso a la tarea
                const nombreTarea = document.querySelector('#tarea').value.trim();
                // Si el nombre de la tarea esta vacio
                if (nombreTarea === '') {
                    // Mostrar una alerta de error
                    mostrarAlerta('error', 'El nombre de la tarea es Obligatorio', document.querySelector('.formulario legend'));

                    return;
                }
                // Si se esta editando una tarea
                if (editar) {
                    // Reescribimos el nombre de la tarea
                    tarea.nombre = nombreTarea;
                    // Editamos el nombre de la tarea
                    actualizarTarea(tarea);
                }
                // Si no se esta editando una tarea existente
                else {
                    // Consultar el Servidor para añador una nueva tarea al proyecto
                    agregarTarea(nombreTarea);
                }
            }
        });

        // Mostramos en el dashboard el modal
        document.querySelector('.dashboard').appendChild(modal);
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
            const url = $_ENV['URL'] + 'api/tarea';
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

    // Cambia el estado de la tarea de PENDIENTE A COMPLETA y viceversa
    function cambiarEstadoTarea(tarea) {
        // Guardamos el nuevo estado de la tarea
        const nuevoEstado = tarea.estado === "1" ? "0" : "1";
        tarea.estado = nuevoEstado;

        // Actializamos el estado de la tarea
        actualizarTarea(tarea);
    }

    // Actualiza el estado de la tarea
    async function actualizarTarea(tarea) {
        // Extraemos los datos de la tarea
        const {id, nombre, estado} = tarea;
        // Guardamos los datos en un FormData
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());

        // Enviamos los datos a la API
        try {
            // Guardamos la url a donde enviar los datos
            const url = $_ENV['URL'] + 'api/tarea/actualizar';

            // Guardamos la respuesta de la API a nuestra peticion
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            
            // Guardamos los datos enviados por la API
            const resultado = await respuesta.json();
            
            // Actualizar el DOM
            if (resultado.respuesta.tipo === 'exito') {
                // Mostramos una alerta de exito
                Swal.fire('ACTUALIZADO CORRECTAMENTE!', resultado.respuesta.mensaje, 'success');
                
                // Eliminamos el modal al cambiar el nombre
                const modal = document.querySelector('.modal');
                if (modal) {
                    modal.remove();   
                }

                // Buscamos la tarea que se le ha cambiado el estado
                tareas = tareas.map(tareaMemoria => {
                    if (tareaMemoria.id === id) {
                        tareaMemoria.estado = estado;
                        tareaMemoria.nombre = nombre;
                    }

                    return tareaMemoria;
                });

                // Limpia el DOM y lo actualiza con el nuevo estado
                mostrarTareas();
            }

        } catch (error) {
            console.log(error);
        }
    }

    // Notificacion de confirmacion a eliminar tarea
    function confirmarEliminarTarea(tarea) {
        // Notificacion de eliminar
        Swal.fire({
            title: '¿ELIMINAR TAREA?',
            showCancelButton: true,
            confirmButtonText: 'SI',
            cancelButtonText: 'NO'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarTarea(tarea);
            }
        });
    }

    async function eliminarTarea(tarea) {
        // Extraemos los datos de la tarea
        const {id, nombre, estado} = tarea;
        
        // Guardamos los datos en un FormData
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());
        

        // Enviamos los datos a la API
        try {
            // Guardamos la url a donde enviar los datos
            const url = $_ENV['URL'] + 'tarea/eliminar';

            // Guardamos la respuesta de la API a nuestra peticion
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            // Guardamos los datos enviados por la API
            const resultado = await respuesta.json();

            // Actualizar el DOM
            if (resultado.resultado) {
                // Mostramos la alerta de eliminado
                Swal.fire('ELIMINADO!', resultado.mensaje, 'success');
                
                // Buscamos las tareas que no se van a eliminar
                tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== tarea.id);

                // Limpia el DOM y borra la tarea
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