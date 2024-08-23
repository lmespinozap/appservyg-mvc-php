<?php

namespace Controllers;

use MVC\Router;

Class CitaController {
    public static function index (Router $router) {

        session_start();

        isAuth();

        $router->render('cita/index', [
            'name' => $_SESSION['name'],
            'id' => $_SESSION['id']
        ]);
    }
}