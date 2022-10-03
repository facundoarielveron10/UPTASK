<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    // Iniciar sesion
    public static function login(Router $router) {
        // Creamos el arreglo de alertas
        $alertas = [];

        // Leemos los datos que manda el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Creamos una instancia de Usuario
            $usuario = new Usuario($_POST);

            // Validamos los datos
            $alertas = $usuario->validarLogin();

            // Si no hubo problemas de validacion
            if (empty($alertas)) {
                // Verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);
                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                } else {
                    // Verificamos que la contraseña sea correcta
                    if ( password_verify($_POST['password'], $usuario->password) ) {
                        // Iniciar las sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar
                        header('Location: /dashboard');
                    }
                    else {
                        Usuario::setAlerta('error', 'La contraseña es incorrecta');
                    }
                }
            }
        }

        //Guardamos las alertas
        $alertas = Usuario::getAlertas();
        // Renderizamos la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion',
            'alertas' => $alertas
        ]);
    }

    // Cerrar sesion
    public static function logout() {
        // Traemos la informacion de la sesion
        session_start();
        // Borramos los datos
        $_SESSION = [];
        // Redireccionamos
        header('Location: /');
    }

    // Crear una sesion
    public static function crear(Router $router) {
        // Instanciamos el objeto Usuario
        $usuario = new Usuario;
        // Creamos el arreglo de alertas
        $alertas = [];

        // Leemos los datos que manda el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizamos los datos que mando el usuario
            $usuario->sincronizar($_POST);
            // Guardamos las alertas de la validacion
            $alertas = $usuario->validarNuevaCuenta();
            // Si no hubo problemas de validacion
            if (empty($alertas)) {
                // Verificamos la existencia de un usuario
                $exiteUsuario = Usuario::where('email', $usuario->email);
                if ($exiteUsuario) {
                    Usuario::setAlerta('error', 'El Usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Crear un nuevo usuario
                    // Hashear el password
                    $usuario->hashPassword();

                    // Eliminar password2
                    unset($usuario->password2);
                    
                    // Generar un token
                    $usuario->crearToken();
                    
                    // Guardamos el usuario en la BD
                    $resultado = $usuario->guardar();

                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Renderizamos la vista
        $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    // Olvide mi password
    public static function olvide(Router $router) {
        // Creamos un arreglo de alertas
        $alertas = [];

        // Leemos los datos que manda el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Creamos un objeto usuario con lel email ingresado
            $usuario = new Usuario($_POST);
            // Validamos el email ingresado
            $alertas = $usuario->validarEmail();

            // Si no hubo problemas de validacion
            if (empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);
                // Econtramos el usuario
                if ($usuario && $usuario->confirmado === '1') {
                    // Creamos un nuevo Token
                    $usuario->crearToken();
                    unset($usuario->password2);
                    // Actualizamos el usuario
                    $usuario->guardar();
                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    // Imprimir la alerta
                    Usuario::setAlerta('exito', 'Se han enviado las instrucciones a su email');
                } 
                // No encontre el usuario
                else {
                    // Disparamos la alerta
                    Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                }
            }
        }

        // Guardamos las alertas
        $alertas = Usuario::getAlertas();
        // Renderizamos la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi password',
            'alertas' => $alertas
        ]);
    }

    // Reestablecer mi password
    public static function reestablecer(Router $router) {
        // Creamos el arreglo de alertas
        $alertas = [];

        // Leemos el token de la URL
        $token = s($_GET['token']);
        $mostrar = true;
        $boton = false;

        // Si alguien intenta entrar a reestablecer
        if (!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        // Si no encontro al usuario
        if (empty($usuario)) {
            // No se encontro un usuario con ese token
            Usuario::setAlerta('error', 'Token no Valido');
            $mostrar = false;
        }
        // Encontramos al usuario
        else {
            // Leemos los datos que manda el usuario
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Reemplazamos la contraseña con la ingresada por el usuario
                $usuario->sincronizar($_POST);
                // Validamos el password
                $alertas = $usuario->validarPassword();
                // Si no hay problemas de validacion
                if (empty($alertas)) {
                    // Hasheamos el password
                    $usuario->hashPassword();
                    // Borramos el token
                    $usuario->token = null;
                    // Guardamos el password
                    $usuario->guardar();
                    // Guardamos la alerta
                    Usuario::setAlerta('exito', 'Contraseña reestablecida correctamente');
                    // Guardamos el boton y ocultamos el ingreso de contraseña
                    $boton = true;
                    $mostrar = false;   
                }
            }
        }
        // Guardamos las alertas
        $alertas = Usuario::getAlertas();
        // Renderizamos la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer mi password',
            'alertas' => $alertas,
            'mostrar' => $mostrar,
            'boton' => $boton
        ]);
    }

    // Mensaje de confirmacion
    public static function mensaje(Router $router) {

        // Renderizamos la vista
        $router->render('auth/mensaje', [
            'titulo' => 'Mensaje'
        ]);
    }

    // Confirmar la cuenta
    public static function confirmar(Router $router) {
        // Leemos el token de la URL
        $token = s($_GET['token']);

        // Si alguien intenta entrar a confirmar
        if (!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);
        
        // Si no encuentra al usuario
        if (empty($usuario)) {
            // No se encontro un usuario con ese token
            Usuario::setAlerta('error', 'Token No Valido');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);

            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Confirmada Correctamente');
        }

        // Guardamos las alertas
        $alertas = Usuario::getAlertas();

        // Renderizamos la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar Cuenta',
            'alertas' => $alertas
        ]);
    }
}