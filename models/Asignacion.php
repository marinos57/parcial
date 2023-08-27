<?php

namespace Model;

class Asignacion extends ActiveRecord {
    protected static $tabla = 'asignacion'; 
    protected static $columnasDB = ['ASIGNA_USUARIO', 'ASIGNA_ROL'];
    protected static $idTabla = 'ASIGNA_ID';

    public $asigna_id;
    public $asigna_usuario;
    public $asigna_rol;

    public function __construct($args = []) {
        $this->asigna_id = $args['asigna_id'] ?? null;
        $this->asigna_usuario = $args['asigna_usuario'] ?? '';
        $this->asigna_rol = $args['asigna_rol'] ?? '';
    }
}
