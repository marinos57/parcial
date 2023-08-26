<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\RegistroController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);


//registros
//$router->get('/', [RegistroController::class,'index']);
$router->get('/registros',[RegistroController::class, 'index']);
$router->post('/API/registros/guardar', [RegistroController::class,'guardarApi']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
