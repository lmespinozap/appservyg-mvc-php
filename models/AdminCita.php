<?php

namespace Model;

class AdminCita extends ActiveRecord {
    protected static $table = 'citasServicios';
    protected static $columnasDB = ['id','hours', 'client', 'email', 'phone', 'service', 'cost'];

    public $id;
    public $hours;
    public $client;
    public $email;
    public $phone;
    public $service;
    public $cost;

    public function __construct( $args = []) {
        $this->id = $args['id'] ?? null;
        $this->hours = $args['hours'] ?? '';
        $this->client = $args['client'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->service = $args['service'] ?? '';
        $this->cost = $args['cost'] ?? 0;
    }
}