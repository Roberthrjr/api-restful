<?php

class PutControlador {

    // PETICION GET CON FILTRO
    static public function getDatosFiltro($tabla, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt) {

        $respuesta = GetModelo::getDatosFiltro($tabla, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

        return $respuesta;

    }    

    // PETICION PUT PARA EDITAR DATOS
    public function putDatos($tabla, $datos, $id, $nameId) {
     
        $respuesta = PutModelo::putDatos($tabla, $datos, $id, $nameId);

        $retornar = new PutControlador();
        $retornar->fncResponse($respuesta, "putDatos");
        
    }

    // RESPUESTA DEL CONTROLADOR
    public function fncResponse($respuesta, $metodo){

		if(!empty($respuesta)){

			$json = array(
				'status' => 200,
				"results" => $respuesta
			);

		}else{

			$json = array(
				'status' => 404,
				"results" => "Not Found",
				'method' => $metodo
			);

		}

		echo json_encode($json, http_response_code($json["status"]));

		return;

	}

}