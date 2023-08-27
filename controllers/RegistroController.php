<?php

namespace Controllers;

use Exception;
use Model\Registro;
use Model\Rol;
use MVC\Router;

class RegistroController {
    public static function index(Router $router){
        // aqui se muestra el formulario de registro
        $router->render('registros/index', []);
    }

    public static function guardarApi(){
        try {
            $nombre = $_POST['usu_nombre'];
            $apellido = $_POST['usu_apellido'];
            $usuario = $_POST['usu_usuario'];
            $password = $_POST['usu_password'];
            
            // aqui se valida si ya existe un usuario con el mismo nombre de usuario
            $usuarioExistente = Registro::fetchFirst("SELECT * FROM usuario WHERE usu_usuario = '$usuario'");
            if ($usuarioExistente) {
                echo json_encode([
                    'mensaje' => 'El nombre de usuario ya está en uso',
                    'codigo' => 0
                ]);
                return;
            }

            // aqui se crea un nuevo objeto Usuario para guardar en la base de datos
            $nuevoUsuario = new Registro([
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
      // Funcion para asignar y modificar rol a los usuarios
      public static function asignarRolApi() {
        try {
            $usu_id = $_POST['usu_id'];
            $rol_id = $_POST['rol_id'];

            $usuario = Registro::find($usu_id);
            if (!$usuario) {
                echo json_encode([
                    'mensaje' => 'Usuario no encontrado',
                    'codigo' => 0
                ]);
                return;
            }

            $rol = Rol::find($rol_id);
            if (!$rol) {
                echo json_encode([
                    'mensaje' => 'Rol no encontrado',
                    'codigo' => 0
                ]);
                return;
            }

            // Asignar el rol al usuario
            $usuario->usu_rol = $rol_id;
            $resultado = $usuario->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Rol asignado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al asignar el rol',
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

    //  para cambiar la contraseña del usuario
    public static function cambiarContrasenaApi() {
        try {
            $usu_id = $_POST['usu_id'];
            $nuevaContrasena = $_POST['nueva_contrasena'];

            $usuario = Registro::find($usu_id);
            if (!$usuario) {
                echo json_encode([
                    'mensaje' => 'Usuario no encontrado',
                    'codigo' => 0
                ]);
                return;
            }

            $usuario->usu_password = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
            $resultado = $usuario->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Contraseña cambiada correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al cambiar la contraseña',
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

    //  para activar usuario
    public static function activarUsuarioApi() {
        try {
            $usu_id = $_POST['usu_id'];

            $usuario = Registro::find($usu_id);
            if (!$usuario) {
                echo json_encode([
                    'mensaje' => 'Usuario no encontrado',
                    'codigo' => 0
                ]);
                return;
            }

            $usuario->usu_situacion = 1;
            $resultado = $usuario->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Usuario activado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al activar el usuario',
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

    // para desactivar usuario
    public static function desactivarUsuarioApi() {
        try {
            $usu_id = $_POST['usu_id'];

            $usuario = Registro::find($usu_id);
            if (!$usuario) {
                echo json_encode([
                    'mensaje' => 'Usuario no encontrado',
                    'codigo' => 0
                ]);
                return;
            }

            $usuario->usu_situacion = 0;
            $resultado = $usuario->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Usuario desactivado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al desactivar el usuario',
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
