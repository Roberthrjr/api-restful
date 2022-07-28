<?php 

class ControladorRutas{

    // RUTA PRINCIPAL
    public function index() {

        include "rutas/ruta.php";

    }

    // NOMBRE DE LA BASE DE DATOS
    static public function database() {
        
        return "reino_animalia";
    
    }
}

?>