<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\servicio;

class APIController {
    public static function index() {
        $servicios = servicio::all();
        echo json_encode($servicios);
        
    }

    public static function guardar() {

        //$respuesta = [
            //'datos' => $_POST
        //]; --> Con esto estabamos comprobando los datos que enviabamos desde app.js 
        // Y ahora lo cambiamos por el nuevo modelo Cita que esta en la carpeta models

        // Almacena la Cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacen los servicios con el Id de la Cita 
        $idServicios = explode(",", $_POST['services']);
        foreach($idServicios as $idServicio) {            
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }
        
        // Retornamos una respuesta.
        echo json_encode(['resultado' => $resultado]);

    }

    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $cita->eliminar();

            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}