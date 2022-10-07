<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
use MVC\Router;
$router = new Router();

//--- AREA - PUBLICA ---//
// Login - Logout
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
// Crear Cuenta
$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);
// Olvide mi password - Colocar el nuevo password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);
// Confirmacion de Cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);
//----------------------//

//--- AREA - PRIVADA ---//
// Principal
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->post('/dashboard', [DashboardController::class, 'index']);
// Crear Proyecto
$router->get('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
$router->post('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
// Proyecto
$router->get('/proyecto', [DashboardController::class, 'proyecto']);
// Modificar Perfil
$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->post('/perfil', [DashboardController::class, 'perfil']);
$router->get('/cambiar-password', [DashboardController::class, 'cambiar_password']);
$router->post('/cambiar-password', [DashboardController::class, 'cambiar_password']);
//----------------------//

//--- API - TAREAS ---//
// Datos Tarea
$router->get('/api/tareas', [TareaController::class, 'index']);
// Crear Tarea
$router->post('/api/tarea', [TareaController::class, 'crear']);
// Actualizar Tarea
$router->post('/api/tarea/actualizar', [TareaController::class, 'actualizar']);
// Eliminar Tarea
$router->post('/api/tarea/eliminar', [TareaController::class, 'eliminar']);
//--------------------//

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();