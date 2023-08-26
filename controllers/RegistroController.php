<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;

class RegistroController {
    public static function index(Router $router){
        // aqui se muestra el formulario de registro
        $router->render('registro/index', []);
    }

    public static function guardarApi(){
        try {
            $nombre = $_POST['usu_nombre'];
            $apellido = $_POST['usu_apellido'];
            $usuario = $_POST['usu_usuario'];
            $password = $_POST['usu_password'];
            
            // aqui se valida si ya existe un usuario con el mismo nombre de usuario
            $usuarioExistente = Usuario::fetchFirst("SELECT * FROM usuario WHERE usu_usuario = '$usuario'");
            if ($usuarioExistente) {
                echo json_encode([
                    'mensaje' => 'El nombre de usuario ya está en uso',
                    'codigo' => 0
                ]);
                return;
            }

            // aqui se crea un nuevo objeto Usuario para guardar en la base de datos
            $nuevoUsuario = new Usuario([
                'usu_nombre' => $nombre,
                'usu_apellido' => $apellido,
                'usu_usuario' => $usuario,
                'usu_password' => password_hash($password, PASSWORD_DEFAULT),
                'usu_situacion' => 0 // Pendiente de activac
            ]);

            $resultado = $nuevoUsuario->guardar(); 

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al guardar el registro',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}
