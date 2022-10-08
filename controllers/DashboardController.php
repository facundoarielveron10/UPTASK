<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
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

        // Creamos el arreglo de alertas
        $alertas = [];

        // Nos traemos todos los datos del Usuario
        $usuario = Usuario::find($_SESSION['id']);

        // Leemos los datos enviados por el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Guardamos los datos enviados por el usuario
            $usuario->sincronizar($_POST);
            // Validamos los datos
            $alertas = $usuario->validarPerfil();

            // Si no hubo problemas de validacion
            if (empty($alertas)) {
                // Validamos el email
                $existeUsuario = Usuario::where('email', $usuario->email);
                
                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    // Mostrar un mensaje de error
                    // Alerta de error
                    Usuario::setAlerta('error', 'Email no valido, ya pertenece a otro usuario');
                    $alertas = $usuario->getAlertas();
                } else {
                    // Guardamos los datos en la base de datos
                    $usuario->guardar();

                    // Alerta de exito
                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $usuario->getAlertas();
                    
                    // Actualizamos los datos de la sesion
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['email'] = $usuario->email;
                }
            }
        }
        
        // Renderizamos las vistas
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    // Cambiar password
    public static function cambiar_password(Router $router) {
        // Iniciamos la session
        session_start();
        
        // Protegemos la ruta
        isAuth();
        
        // Creamos el arreglo de alertas
        $alertas = [];

        // Leemos los datos enviados por el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Identificamos al usuario que quiere cambiar su password
            $usuario = Usuario::find($_SESSION['id']);
            // Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);
            // Validamos los datos
            $alertas = $usuario->nuevoPassword();

            // Si no hubo problemas de validacion
            if (empty($alertas)) {
                $resultado = $usuario->comprobarPassword();
                
                // Si el password es correcto
                if ($resultado) {
                    // Asignar el nuevo password
                    $usuario->password = $usuario->password_nuevo;
                    // Eliminarmos el password_actual ya que ya se verefico que es correcto
                    unset($usuario->password_actual);
                    // Eliminamos el password_nuevo
                    unset($usuario->password_nuevo);
                    // Hashear el password
                    $usuario->hashPassword();
                    // Guardamos los datos en la base de datos
                    $resultado = $usuario->guardar();

                    // Si no hubo problemas
                    if ($resultado) {
                        Usuario::setAlerta('exito', 'Password Actulizado Correctamente');
                        $alertas = $usuario->getAlertas();
                    }

                } else {
                    Usuario::setAlerta('error', 'Password incorrecto');
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        // Renderizamos la vista
        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas

        ]);
    }
}