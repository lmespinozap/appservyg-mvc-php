<?php 

namespace Model;

class Cita extends ActiveRecord {
    // Base de datos

    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'datecita', 'hours', 'userId'];
    
    public $id;
    public $datecita;
    public $hours;
    public $userId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->datecita = $args['datecita'] ?? '';
        $this->hours = $args['hours'] ?? '';
        $this->userId = $args['userId'] ?? '';
    }
}