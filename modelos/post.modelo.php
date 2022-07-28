<?php 

require_once "conexion.php";

class PostModelo {

    // PETICION DE TRAER LOS NOMBRES DE LAS COLUMNAS
    static public function getDatosColumna($tabla, $database) {

        return Conexion::conectar()->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$tabla'") -> fetchAll(PDO::FETCH_OBJ);

    }

    // PETICION POST PARA CREAR DATOS
    static public function postDatos($tabla, $datos) {

        $columnas = "(";
        $parametros = "(";

        foreach ($datos as $key => $value) {
            
            $columnas .= $key.",";
            $parametros .= ":".$key.",";

        }

        $columnas = substr($columnas, 0, -1);
        $parametros = substr($parametros, 0, -1);

        $columnas .= ")";
        $parametros .= ")";

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla $columnas VALUES $parametros");

        foreach ($datos as $key => $value) {
            
            $stmt->bindParam(":".$key, $datos[$key], PDO::PARAM_STR);

        }

        if ( $stmt -> execute() ) {

            return "ok";

        } else {

            return Conexion::conectar()->errorInfo();

        }

    }

}

?>