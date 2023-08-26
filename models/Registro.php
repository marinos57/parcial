<?php

namespace Model;

class Registro extends ActiveRecord {
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['USU_NOMBRE', 'USU_APELLIDO', 'USU_USUARIO', 'USU_PASSWORD', 'USU_SITUACION'];
    protected static $idTabla = 'USU_ID';

    public $usu_id;
    public $usu_nombre;
    public $usu_apellido;
    public $usu_usuario;
    public $usu_password;
    public $usu_situacion;

    public function __construct($args = []) {
        $this->usu_id = $args['usu_id'] ?? null;
        $this->usu_nombre = $args['usu_nombre'] ?? '';
        $this->usu_apellido = $args['usu_apellido'] ?? '';
        $this->usu_usuario = $args['usu_usuario'] ?? '';
        $this->usu_password = $args['usu_password'] ?? '';
        $this->usu_situacion = $args['usu_situacion'] ?? 0;
    }
}
