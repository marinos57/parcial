<?php

namespace Controllers;

use Exception;
use Model\Registro;
use Model\Asignacion;
use MVC\Router;

class ListadoController {
    public static function index(Router $router){
        // aqui se muestra el formulario de registro
        $router->render('listados/index', []);
    }
 }