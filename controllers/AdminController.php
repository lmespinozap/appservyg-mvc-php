<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index( Router $router ) {
        session_start();

        isAdmin();

        $dateCita = $_GET['fecha'] ?? date('Y-m-d');
        $dateCitas = explode('-', $dateCita);

        if( !checkdate( $dateCitas[1], $dateCitas[2], $dateCitas[0])) {
            header('Location: /404');
        }        

        // Consultar la Base de Datos
        $consulta = "SELECT citas.id, citas.hours, CONCAT( usuarios.name, ' ', usuarios.lastname) as client, ";
        $consulta .= " usuarios.email, usuarios.phone, servicios.name as service, servicios.cost  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.userId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE dateCita =  '${dateCita}' ";

        $citas = AdminCita::SQL($consulta);
        

        $router->render('admin/index', [
            'name' => $_SESSION['name'],
            'citas' => $citas,
            'dateCita' => $dateCita
        ]);
    }
    
}
