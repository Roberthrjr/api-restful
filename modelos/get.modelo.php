<?php 

require_once "conexion.php";

class GetModelo {

    // PETICIONES GET SIN FILTRO
    static public function getDatos($tabla, $orderBy, $orderMode, $startAt, $endAt) {

        // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN Y LIMITES
        if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orderBy $orderMode");

        } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");

        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        }

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_CLASS); 

    }

    // PETICIONES GET CON FILTRO
    static public function getDatosFiltro($tabla, $linkTo, $equalTo,  $orderBy, $orderMode, $startAt, $endAt) {

        // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN Y LIMITES
        if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $linkTo = :$linkTo ORDER BY $orderBy $orderMode");

        } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $linkTo = :$linkTo ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");
        
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $linkTo = :$linkTo");

        }

        $stmt -> bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR);

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_CLASS); 

    }

    // PETICIONES GET DE TABLAS RELACIONADAS (hija - padre) SIN FILTRO
    static public function getDatosRelacion($rel, $type, $orderBy, $orderMode, $startAt, $endAt) {

        $relArray = explode(",", $rel);

        $typeArray = explode(",", $type);

        // RELACION DE 2 TABLAS SIN FILTRO       
        if ( count($relArray) == 2 && count($typeArray) == 2 ) {

            $primerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[1]."_".$typeArray[0];

            $primerIdentificadorSegundaTabla = $relArray[1].".id_".$typeArray[1];

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN Y LIMITES
            if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla ORDER BY $orderBy $orderMode");

            } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");

            } else {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla");

            }
        }

        // RELACION DE 3 TABLAS SIN FILTRO
        if ( count($relArray) == 3 && count($typeArray) == 3 ) {

            $primerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[1]."_".$typeArray[0];
            $segundoIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[2]."_".$typeArray[0];

            $primerIdentificadorSegundaTabla = $relArray[1].".id_".$typeArray[1];
            $primerIdentificadorTerceraTabla = $relArray[2].".id_".$typeArray[2];

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ){

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla ORDER BY $orderBy $orderMode");

            } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");
            
            } else {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla");

            }

        }

        // RELACION DE 4 TABLAS SIN FILTRO
        if ( count($relArray) == 4 && count($typeArray) == 4 ) {

            $primerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[1]."_".$typeArray[0];
            $segundoIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[2]."_".$typeArray[0];
            $tercerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[3]."_".$typeArray[0];

            $primerIdentificadorSegundaTabla = $relArray[1].".id_".$typeArray[1];
            $primerIdentificadorTerceraTabla = $relArray[2].".id_".$typeArray[2];
            $primerIdentificadorCuartaTabla = $relArray[3].".id_".$typeArray[3];

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla INNER JOIN $relArray[3] ON $tercerIdentificadorPrimerTabla = $primerIdentificadorCuartaTabla ORDER BY $orderBy $orderMode");

            } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla INNER JOIN $relArray[3] ON $tercerIdentificadorPrimerTabla = $primerIdentificadorCuartaTabla ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");

            } else {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla INNER JOIN $relArray[3] ON $tercerIdentificadorPrimerTabla = $primerIdentificadorCuartaTabla");

            }

        }

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_CLASS);

    }

    // PETICIONES GET DE TABLAS RELACIONADAS (hija - padre) CON FILTRO
    static public function getDatosRelacionFiltro($rel, $type, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt) {

        $relArray = explode(",", $rel);

        $typeArray = explode(",", $type);

        // RELACION DE 2 TABLAS CON FILTRO
        if ( count($relArray) == 2 && count($typeArray) == 2 ) {

            $primerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[1]."_".$typeArray[0];

            $primerIdentificadorSegundaTabla = $relArray[1].".id_".$typeArray[1];

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla WHERE $linkTo = :$linkTo ORDER BY $orderBy $orderMode");

            } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla WHERE $linkTo = :$linkTo ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt");

            } else {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla WHERE $linkTo = :$linkTo");

            }

        }

        // RELACION DE 3 TABLAS CON FILTRO
        if ( count($relArray) == 3 && count($typeArray) == 3 ) {

            $primerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[1]."_".$typeArray[0];
            $segundoIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[2]."_".$typeArray[0];

            $primerIdentificadorSegundaTabla = $relArray[1].".id_".$typeArray[1];
            $primerIdentificadorTerceraTabla = $relArray[2].".id_".$typeArray[2];

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {
                
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla WHERE $linkTo = :$linkTo ORDER BY $orderBy $orderMode");

            } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {
                
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla WHERE $linkTo = :$linkTo ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");

            } else {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla WHERE $linkTo = :$linkTo");

            }

        }

        // RELACION DE 4 TABLAS CON FILTRO
        if ( count($relArray) == 4 && count($typeArray) == 4 ) {

            $primerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[1]."_".$typeArray[0];
            $segundoIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[2]."_".$typeArray[0];
            $tercerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[3]."_".$typeArray[0];

            $primerIdentificadorSegundaTabla = $relArray[1].".id_".$typeArray[1];
            $primerIdentificadorTerceraTabla = $relArray[2].".id_".$typeArray[2];
            $primerIdentificadorCuartaTabla = $relArray[3].".id_".$typeArray[3];

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {
                
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla INNER JOIN $relArray[3] ON $tercerIdentificadorPrimerTabla = $primerIdentificadorCuartaTabla  WHERE $linkTo = :$linkTo ORDER BY $orderBy $orderMode");

            } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {
                
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla INNER JOIN $relArray[3] ON $tercerIdentificadorPrimerTabla = $primerIdentificadorCuartaTabla  WHERE $linkTo = :$linkTo ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");
                
            } else {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla INNER JOIN $relArray[3] ON $tercerIdentificadorPrimerTabla = $primerIdentificadorCuartaTabla  WHERE $linkTo = :$linkTo");

            }

        }

        $stmt -> bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR);

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_CLASS);

    }

    // PETICIONES GET PARA EL BUSCADOR
    static public function getDatosBusqueda($tabla, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt) {

        if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {
        
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode");

        } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {
            
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");
        
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $linkTo LIKE '%$search%'");

        }

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_CLASS); 

    }

    // PETICION GET PARA BUSQUEDAS ENTRE TABLAS RELACIONADAS
    static public function getDatosBusquedaRelacion($rel, $type, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt) {

        $relArray = explode(",", $rel);
        $typeArray = explode(",", $type);

        // RELACION DE 2 TABLAS CON FILTRO
        if ( count($relArray) == 2 && count($typeArray) == 2 ) {

            $primerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[1]."_".$typeArray[0];

            $primerIdentificadorSegundaTabla = $relArray[1].".id_".$typeArray[1];

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla WHERE $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode");

            } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla WHERE $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt");

            } else {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla WHERE $linkTo LIKE '%$search%'");

            }

        }

        // RELACION DE 3 TABLAS CON FILTRO
        if ( count($relArray) == 3 && count($typeArray) == 3 ) {

            $primerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[1]."_".$typeArray[0];
            $segundoIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[2]."_".$typeArray[0];

            $primerIdentificadorSegundaTabla = $relArray[1].".id_".$typeArray[1];
            $primerIdentificadorTerceraTabla = $relArray[2].".id_".$typeArray[2];

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {
                
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla WHERE $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode");

            } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {
                
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla WHERE $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");

            } else {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla WHERE $linkTo LIKE '%$search%'");

            }

        }

        // RELACION DE 4 TABLAS CON FILTRO
        if ( count($relArray) == 4 && count($typeArray) == 4 ) {

            $primerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[1]."_".$typeArray[0];
            $segundoIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[2]."_".$typeArray[0];
            $tercerIdentificadorPrimerTabla = $relArray[0].".id_".$typeArray[3]."_".$typeArray[0];

            $primerIdentificadorSegundaTabla = $relArray[1].".id_".$typeArray[1];
            $primerIdentificadorTerceraTabla = $relArray[2].".id_".$typeArray[2];
            $primerIdentificadorCuartaTabla = $relArray[3].".id_".$typeArray[3];

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( $orderBy != null && $orderMode != null && $startAt == null && $endAt == null ) {
                
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla INNER JOIN $relArray[3] ON $tercerIdentificadorPrimerTabla = $primerIdentificadorCuartaTabla  WHERE $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode");

            } else if ( $orderBy != null && $orderMode != null && $startAt != null && $endAt != null ) {
                
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla INNER JOIN $relArray[3] ON $tercerIdentificadorPrimerTabla = $primerIdentificadorCuartaTabla  WHERE $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");
                
            } else {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $primerIdentificadorPrimerTabla = $primerIdentificadorSegundaTabla INNER JOIN $relArray[2] ON $segundoIdentificadorPrimerTabla = $primerIdentificadorTerceraTabla INNER JOIN $relArray[3] ON $tercerIdentificadorPrimerTabla = $primerIdentificadorCuartaTabla  WHERE $linkTo LIKE '%$search%'");

            }

        }

        $stmt -> bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR);

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_CLASS);
        

    }
    
}

?>