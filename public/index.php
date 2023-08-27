<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\RegistroController;
use Controllers\ListadoController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);


//registros
//$router->get('/', [RegistroController::class,'index']);
$router->get('/registros',[RegistroController::class, 'index']);
$router->post('/API/registros/guardar', [RegistroController::class,'guardarApi']);




//listados
$router->get('/listados',[ListadoController::class, 'index']);
$router->post('/API/listados/guardar', [RegistroController::class,'guardarApi']);
$router->post('/API/listados/desactivarUsuario', [RegistroController::class,'desactivarUsuarioApi']);
$router->post('/API/listados/activarUsuario', [RegistroController::class,'activarUsuarioApi']);
$router->post('/API/listados/CambiarContrasena', [RegistroController::class,'CambiarContrasenaApi']);
$router->post('/API/listados/asignaRol', [RegistroController::class,'asignaRolApi']);
$router->get('/API/listados/buscar', [RegistroController::class,'buscarApi']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
