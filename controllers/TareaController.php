<?php

namespace Controllers;

class TareaController {
    //--- API ---/

    // Traerse los datos
    public static function index() {
        
    }

    // Crear una tarea
    public static function crear() {
        // Leemos los datos enviados por el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Enviamos los datos
            echo json_encode($_POST);
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