<?php

class DeleteControlador {

    // PETICION DELETE PARA BORRAR LOS DATOS
    public function deleteDatos($tabla, $id, $nameId) {

        $respuesta = DeleteModelo::deleteDatos($tabla, $id, $nameId);

        $retornar = new DeleteControlador();
        $retornar -> fncRespuesta($respuesta, "deleteDatos");

    }

    // RESPUESTA DEL CONTROLADOR
    public function fncRespuesta($respuesta, $metodo){

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