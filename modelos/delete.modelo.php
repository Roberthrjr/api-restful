<?php

require_once "conexion.php";

class DeleteModelo {

    // PETICION DE DELETE PARA BORRAR LOS DATOS
    static public function deleteDatos($tabla, $id, $nameId) {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $nameId = :$nameId");

        $stmt -> bindParam(":".$nameId, $id, PDO::PARAM_INT);

        if ( $stmt -> execute() ) {

            return "ok";

        } else {

            return Conexion::conectar()->errorInfo();
        
        }

    }

}