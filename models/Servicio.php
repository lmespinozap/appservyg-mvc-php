<?php
namespace Model;

class servicio extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'name', 'cost'];

    public $id;
    public $name;
    public $cost;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->cost = $args['cost'] ?? 0;
    }

    public function validar() {
        if(!$this->name) {
            self::$alertas['error'][] = 'El Nombre del Servicio es Obligatorio';
        }
        if(!$this->cost) {
            self::$alertas['error'][] = 'El Precio del Servicio es Obligatorio';
        }
        if(!is_numeric($this->cost)) {
            self::$alertas['error'][] = 'El precio no es válido';
        }

        return self::$alertas;
    }
}