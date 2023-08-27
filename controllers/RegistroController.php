<?php

namespace Controllers;

use Exception;
use Model\Registro;
use Model\Asignacion;
use MVC\Router;

class RegistroController
{
    public static function index(Router $router)
    {
        // aqui se muestra el formulario de registro
        $router->render('registros/index', []);
    }

    public static function guardarApi()
    {
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
    // Función para asignar y modificar rol a los usuarios
    public static function asignaRolApi()
    {
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

            $asignacion = new Asignacion([
                'asigna_usuario' => $usu_id,
                'asigna_rol' => $rol_id
            ]);

            $resultado = $asignacion->guardar();

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





    public static function buscarApi()
    {
        $usu_nombre = $_GET['usu_nombre'];
        $usu_apellido = $_GET['usu_apellido'];
        $usu_usuario = $_GET['usu_usuario'];
    
        $whereClauses = array();
    
        if ($usu_nombre) {
            $whereClauses[] = "usu_nombre LIKE '%$usu_nombre%'";
        }
    
        if ($usu_apellido) {
            $whereClauses[] = "usu_apellido LIKE '%$usu_apellido%'";
        }
    
        if ($usu_usuario) {
            $whereClauses[] = "usu_usuario LIKE '%$usu_usuario%'";
        }
        $sql = "SELECT usu_id, usu_nombre, usu_apellido, usu_usuario, usu_situacion FROM usuario"; 
    
        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }
    
        try {
            $usuarios = Registro::fetchArray($sql);
            header('Content-Type: application/json');
            echo json_encode($usuarios);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    


    //  para cambiar la contraseña del usuario
    public static function cambiarContrasenaApi()
    {
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
    public static function activarUsuarioApi()
    {
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
    public static function desactivarUsuarioApi()
    {
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
