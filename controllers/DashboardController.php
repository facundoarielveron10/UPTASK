<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController {
    // Principal
    public static function index(Router $router) {
        // Iniciamos la sesion
        session_start();

        // Verificamos que el usuario este autenticado
        isAuth();

        // Traernos todos los proyectos creados por el dueño
        $proyectos = Proyecto::belongsTo('propietarioId', $_SESSION['id']);
        
        // Renderizamos la vista
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    // Crear un proyecto
    public static function crear_proyecto(Router $router) {
        // Iniciamos la sesion
        session_start();

        // Verificamos que el usuario este autenticado
        isAuth();

        // Creamos el arreglo de alertas
        $alertas = [];

        // Leemos los datos enviados
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Instanciamos un objeto Proyecto
            $proyecto = new Proyecto($_POST);
            // Validacion de los datos
            $alertas = $proyecto->validarProyecto();

            // Si no hubo problemas de validacion
            if (empty($alertas)) {
                // Generar una URL unica
                $proyecto->url = md5(uniqid());
                // Almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];
                // Guardar el proyecto
                $proyecto->guardar();

                // Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url);
            }
        }

        // Renderizamos las vistas
        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Crear Proyecto'
        ]);
    }

    // Ver el proyecto creado
    public static function proyecto(Router $router) {
        // Iniciamos la sesion
        session_start();

        // Verificamos que el usuario este autenticado
        isAuth();

        // Leemos la url
        $token = $_GET['id'];

        // Validamos que exista ese token
        if (!$token) header('Location: /dashboard');

        // Validamos que sea el dueño del proyecto
        $proyecto = Proyecto::where('url', $token);
        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }
        
        // Renderizamos la vista
        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    // Modificar perfil
    public static function perfil(Router $router) {
        // Iniciamos la sesion
        session_start();

        // Verificamos que el usuario este autenticado
        isAuth();


        // Renderizamos las vistas
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
        ]);
    }
}