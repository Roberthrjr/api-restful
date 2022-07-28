<?php 

class GetControlador {

    // PETICIONES GET SIN FILTRO
    public function getDatos($tabla, $orderBy, $orderMode, $startAt, $endAt) {

        $respuesta = GetModelo::getDatos($tabla, $orderBy, $orderMode, $startAt, $endAt);

        $retornar = new GetControlador();
        $retornar -> fncRespuesta($respuesta, "getDatos");
    
    }

    // PETICIONES GET CON FILTRO
    public function getDatosFiltro($tabla, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt) {

        $respuesta = GetModelo::getDatosFiltro($tabla, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

        $retornar = new GetControlador();
        $retornar -> fncRespuesta($respuesta, "getDatosFiltro");
    
    }

    // PETICIONES GET DE TABLAS RELACIONADAS SIN FILTRO
    public function getDatosRelacion($rel, $type, $orderBy, $orderMode, $startAt, $endAt) {
        
        $respuesta = GetModelo::getDatosRelacion($rel, $type, $orderBy, $orderMode, $startAt, $endAt);

        $retornar = new GetControlador();
        $retornar -> fncRespuesta($respuesta, "getDatosRelacion");

    }

    // PETICIONES GET DE TABLAS RELACIONADAS CON FILTRO
    public function getDatosRelacionFiltro($rel, $type, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt) {

        $respuesta = GetModelo::getDatosRelacionFiltro($rel, $type, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

        $retornar = new GetControlador();
        $retornar -> fncRespuesta($respuesta, "getDatosRelacionFiltro");

    }

    // PETICIONES GET PARA EL BUSCADOR
    public function getDatosBusqueda($tabla, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt) {

        $respuesta = GetModelo::getDatosBusqueda($tabla, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt);

        $retornar = new GetControlador();
        $retornar -> fncRespuesta($respuesta, "getDatosBusqueda");

    }

    // RESPUESTAS DEL CONTROLADOR
    public function fncRespuesta($respuesta, $metodo) {

        if ( !empty($respuesta) ) {

            $json = array(
                'status' => 200,
                'total' => count($respuesta),
                'results' => $respuesta
            );

        } else {

            $json = array(
                'status' => 404,
                'results' => "Not Found",
                'method' => $metodo
            );

        }

        echo json_encode($json, http_response_code($json["status"]));

        return;

    }

}

?>
