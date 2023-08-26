<?php
namespace Model;

class Rol extends ActiveRecord {
    protected static $tabla = 'rol'; 
    protected static $columnasDB = ['ROL_NOMBRE', 'ROL_NOMBRE_CT', 'ROL_APP', 'ROL_SITUACION'];
    protected static $idTabla = 'ROL_ID';

    public $rol_id;
    public $rol_nombre;
    public $rol_nombre_ct;
    public $rol_app;
    public $rol_situacion;

    public function __construct($args = []) {
        $this->rol_id = $args['rol_id'] ?? null;
        $this->rol_nombre = $args['rol_nombre'] ?? '';
        $this->rol_nombre_ct = $args['rol_nombre_ct'] ?? '';
        $this->rol_app = $args['rol_app'] ?? '';
        $this->rol_situacion = $args['rol_situacion'] ?? '';
    }
}
