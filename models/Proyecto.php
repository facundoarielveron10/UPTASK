<?php

namespace Model;

use Model\ActiveRecord;

class Proyecto extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioId'];

    // Constructor
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? '';
    }

    // Metodos
    // Valida los datos enviados para crear un proyecto
    public function validarProyecto() {
        if (!$this->proyecto) {
            self::$alertas['error'][] = 'El nombre del Proyecto es Obligatorio';
        }
        
        return self::$alertas;
    }
}