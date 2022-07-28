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
				'estado' => 200,
				"resultados" => $respuesta
			);

		}else{

			$json = array(
				'estado' => 404,
				"resultados" => "No encontrado",
				'metodo' => $metodo
			);

		}

		echo json_encode($json, http_response_code($json["estado"]));

		return;

	}

}