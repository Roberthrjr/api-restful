<?php

require_once "conexion.php";

class PutModelo {
    
    // PETICION PUT PARA EDITAR DATOS
    static public function putDatos($tabla, $datos, $id, $nameId) {

        $set = "";

        foreach ($datos as $key => $value) {
            
            $set .= $key." = :".$key.",";

        }

        $set = substr($set, 0, -1);

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $set WHERE $nameId = :$nameId");

        foreach ($datos as $key => $value) {
            
            $stmt->bindParam(":".$key, $datos[$key], PDO::PARAM_STR);
            
        }

        $stmt->bindParam(":".$nameId, $id, PDO::PARAM_INT);

        if ( $stmt -> execute() ) {

            return "ok";

        } else {

            return Conexion::conectar()->errorInfo();

        }

    }

}