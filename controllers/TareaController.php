<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController {
    //--- API ---/

    // Traerse los datos
    public static function index() {
        // Leemos el id de la URL
        $urlId = $_GET['id'];
        // Verificamos que este en la URL ese id
        if (!$urlId) header('Location: /dashboard');
        // Nos traemos el proyecto asociado a ese id
        $proyecto = Proyecto::where('url', $urlId);

        // Iniciamos la Sesion para traernos el arreglo de $_SESSION
        session_start();
        // Verificamos la existencia y pertenencia de ese proyecto
        if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header('Location: /404');
        // Guardamos todas las tareas asociadas a ese proyecto
        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);
        
        // Enviamos todas las tareas
        echo json_encode(['tareas' => $tareas]);
    }

    // Crear una tarea
    public static function crear() {
        // Leemos los datos enviados por el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Iniciamos sesion para traernos el arreglo de $_SESSION
            session_start();

            // Instanciamos un Proyecto
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            // Si no existe ese proyecto
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                // Guardamos los datos de la alerta
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al agregar la tarea'
                ];
                // Mandamos la alerta
                echo json_encode($respuesta);
                return;
            }

            // Todo bien, instanciar y crear la tarea
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            // Guardamos los datos de la alerta
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea Creada Correctamente',
                'proyectoId' => $proyecto->id
            ];
            // Enviamos la alerta
            echo json_encode($respuesta);
        }
    }

    // Actualiza una tarea
    public static function actualizar() {
        // Leemos los datos enviados por el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }

    // Elimina una tarea
    public static function eliminar() {
        // Leemos los datos enviados por el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }
}