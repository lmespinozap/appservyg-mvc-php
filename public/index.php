<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use MVC\Router;
use Controllers\LoginController;
use Controllers\CitaController;
use Controllers\ServicioController;
$router = new Router();

//Iniciar Sesión
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//Recuperar password
$router->get('/forget', [LoginController::class, 'forget']); //Clase get de Olvide contraseña
$router->post('/forget', [LoginController::class, 'forget']); //Clase post de Olvide contraseña
$router->get('/recover', [LoginController::class, 'recover']); //Clase get de Recuperar contraseña
$router->post('/recover', [LoginController::class, 'recover']); //Clase post de Recuperar contraseña


// Crear Cuenta
$router->get('/create-account', [LoginController::class, 'create']); //Clase get de Crear Cuenta
$router->post('/create-account', [LoginController::class, 'create']); //Clase post de Crear Cuenta

// Confirmar la cuenta 
$router->get('/confirm-account', [LoginController::class, 'confirm']); //Clase
$router->get('/message', [LoginController::class, 'message']); //Clase

//Area Privada
$router->get('/cita', [CitaController::class, 'index']); //Clase
$router->get('/admin', [AdminController::class, 'index']); //Llama la url de Aminostrador de AdmiinController 

// API de Citas
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']); // Enlace de API, para guardar las citas
$router->post('/api/deletecita',[APIController::class, 'eliminar']); 

// CRUD de Servicios 
$router->get('/servicios',[ServicioController::class, 'index']);
$router->get('/servicios/crear',[ServicioController::class, 'crear']);
$router->post('/servicios/crear',[ServicioController::class, 'crear']);
$router->get('/servicios/actualizar',[ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar',[ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar',[ServicioController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();