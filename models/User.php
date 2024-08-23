<?php

namespace Model;

class User extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'name', 'lastname', 'email', 'password', 'phone', 'admin', 'confirm', 'token'];

    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $phone;
    public $admin;
    public $confirm;
    public $token;

    public function __construct( $args = []) {
        $this->id = $args['id'] ?? null ;
        $this->name = $args['name'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirm = $args['confirm'] ?? '0';
        $this->token = $args['token'] ?? '';
        
    }

    // Mensaje de validación para la creación de la cuenta
    public function validarCuenta() {
        if(!$this->name) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->lastname) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }

        if(!$this->email) {
            self::$alertas['error'][] = 'El correo electrónico es obligatorio';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        if(!$this->phone) {
            self::$alertas['error'][] = 'El teléfono es obligatorio';
        }

        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;

    }

    // Validar el Login
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es Obligatorio';
        }
        
        return self::$alertas;
    }

    public function validarEmail (){
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es Obligatorio';
        }
        if(strlen($this->password)<6) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    // Revisa si el usuario existe
    public function existUser() {
        $query = "SELECT * FROM ". self::$tabla . " WHERE email = '" . $this->email ."' LIMIT 1";    
        $resultado = self::$db->query($query);


        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }

        return $resultado;
    }

    // Hash al password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);
        
        if(!$resultado || !$this->confirm) {
            self::$alertas['error'][] = 'Password Incorrecto o tú cuenta no ha sido Confirmada';
        } else {
            return true;
        }
    }

}