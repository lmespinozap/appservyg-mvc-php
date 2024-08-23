<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController {
    public static function login (Router $router) {
        $alertas = [];

        $auth = new User;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);

            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = User::where('email', $auth->email);
                
                if($usuario) {
                    // Verificar el password
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)){
                        // Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['name'] = $usuario->name . " " . $usuario->lastname;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        };

                        debuguear($_SESSION);

                    };

                } else {
                    User::setAlerta('error', 'El usuario no existe');
                }
            }
        }

        $alertas = User::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    public static function logout() {
        session_start();
        //debuguear($_SESSION); --> comprobamos los datos de la sesión activa

        $_SESSION = []; // Borramos los datos de la sesión activa, devolviendo un arreglo vacio
        // Redirigimos al usuario a la pagina de login
        header('Location: /');
    }

    public static function forget(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                // Enviar correo electrónico
                $usuario = User::where('email', $auth->email);
                
                if($usuario && $usuario->confirm === "1") {

                    // Generar Token
                    $usuario->createToken();
                    $usuario->guardar();

                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->name, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de exito
                    User::setAlerta('exito', 'Revisa tú email');


                } else {
                    User::setAlerta('error', 'El usuario no existe o no ha sido confirmado');
                }
            }

        }

        $alertas = User::getAlertas();

        $router->render('auth/forget-password',[
            'alertas' => $alertas
        ]);
    }

    public static function recover(Router $router) {
        
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        // Buscamos usuario en la base de datos
        $usuario = User::where('token', $token);

        if(empty($usuario)) {
            User::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo
            $password = new User($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }
            }
        }

        //debuguear($usuario);
        $alertas = User::getAlertas();
        $router->render('auth/recover-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function create(Router $router) {
        $usuario = new User;

        //Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarCuenta();

            if(empty($alertas)) {
                //Verificando si existe este usuario --> lo hacemos revisando el email
                $resultado = $usuario->existUser();

                if($resultado->num_rows) {
                    $alertas = User::getAlertas();
                } else {
                    //Hash al password
                    $usuario->hashPassword();

                    
                    // Generar un token único
                    $usuario->createToken();

                    // Enviar el email.
                    $email = new Email($usuario->email, $usuario->name, $usuario->token);
                    $email->enviarConfirmacion();
                    
                    //Crear el registro del usuario
                    $resultado = $usuario->guardar();
                    if($resultado) {
                        header('Location: /message');
                    }

                }

            }
        }

        $router->render('auth/create-account',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function message (Router $router) {
        $router->render('auth/message');
    }

    public static function confirm (Router $router) {
        $alertas = [];

        $token = s($_GET['token']);
        $usuario = User::where('token', $token);

        if(empty($usuario)) {
            // Mostrar mensaje de error
            User::setAlerta('error', 'Token no válido');
        } else {
            // Modificar a usuario confirmado
            $usuario->confirm = 1;
            $usuario->token = NULL;
            $usuario->guardar();
            User::setAlerta('exito', 'Cuenta confirmada correctamente');

        }

        $alertas = User::getAlertas();
        $router->render('auth/confirm-account', [
            'alertas' => $alertas
        ]);
    }
}