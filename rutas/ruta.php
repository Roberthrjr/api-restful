<?php 

$rutasArray = explode("/",$_SERVER['REQUEST_URI']);

$rutasArray = array_filter($rutasArray);

// CUANDO NO SE HACE NINGUNA PETICION A LA API
if ( count( $rutasArray ) == 0 ) {

    $json = array(
        'estado' => 404,
        'resultado' => "No encontrado"
    );
    
    echo json_encode($json, http_response_code($json["estado"]));

    return;

} else {

    // PETICIONES GET
    if ( count( $rutasArray ) == 1 && isset( $_SERVER["REQUEST_METHOD"] ) && $_SERVER["REQUEST_METHOD"] == "GET" ) {

        // PETICIONES GET CON FILTRO
        if ( isset($_GET["linkTo"]) && isset($_GET["equalTo"]) && !isset($_GET["rel"]) && !isset($_GET["type"]) ) {

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( isset($_GET["orderBy"]) && isset($_GET["orderMode"]) ) {

                $orderBy = $_GET["orderBy"];

                $orderMode = $_GET["orderMode"];

            } else {

                $orderBy = null;

                $orderMode = null;

            }

            // PREGUNTAMOS SI VIENEN VARIABLES DE LIMITES
            if ( isset($_GET["startAt"]) && isset($_GET["endAt"]) ) {

                $startAt = $_GET["startAt"];
                
                $endAt = $_GET["endAt"];

            } else {

                $startAt = null;

                $endAt = null;

            }

            $respuesta = new GetControlador();

            $respuesta -> getDatosFiltro(explode("?",$rutasArray[1])[0], $_GET["linkTo"], $_GET["equalTo"], $orderBy, $orderMode, $startAt, $endAt);

        // PETICIONES GET ENTRE TABLAS RELACIONADAS SIN FILTRO
        } else if ( isset($_GET["rel"]) && isset($_GET["type"]) && explode("?",$rutasArray[1])[0] == "relations" && !isset($_GET["linkTo"]) && !isset($_GET["equalTo"])) {

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( isset($_GET["orderBy"]) && isset($_GET["orderMode"]) ) {

                $orderBy = $_GET["orderBy"];

                $orderMode = $_GET["orderMode"];

            } else {

                $orderBy = null;

                $orderMode = null;

            }

            // PREGUNTAMOS SI VIENEN VARIABLES DE LIMITES
            if ( isset($_GET["startAt"]) && isset($_GET["endAt"]) ) {

                $startAt = $_GET["startAt"];
                
                $endAt = $_GET["endAt"];

            } else {

                $startAt = null;

                $endAt = null;

            }

            $respuesta = new GetControlador();

            $respuesta -> getDatosRelacion($_GET["rel"], $_GET["type"], $orderBy, $orderMode, $startAt, $endAt);

        // PETICIONES GET ENTRE TABLAS RELACIONADAS CON FILTRO
        } else if ( isset($_GET["rel"]) && isset($_GET["type"]) && explode("?",$rutasArray[1])[0] == "relations" && isset($_GET["linkTo"]) && isset($_GET["equalTo"]) ) {

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( isset($_GET["orderBy"]) && isset($_GET["orderMode"]) ) {

                $orderBy = $_GET["orderBy"];

                $orderMode = $_GET["orderMode"];

            } else {

                $orderBy = null;

                $orderMode = null;

            }

            // PREGUNTAMOS SI VIENEN VARIABLES DE LIMITES
            if ( isset($_GET["startAt"]) && isset($_GET["endAt"]) ) {

                $startAt = $_GET["startAt"];
                
                $endAt = $_GET["endAt"];

            } else {

                $startAt = null;

                $endAt = null;

            }

            $respuesta = new GetControlador();

            $respuesta -> getDatosRelacionFiltro($_GET["rel"], $_GET["type"], $_GET["linkTo"], $_GET["equalTo"], $orderBy, $orderMode, $startAt, $endAt);

        // PETICIONES GET PARA EL BUSCADOR
        } else if ( isset($_GET["linkTo"]) && isset($_GET["search"]) ) {

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( isset($_GET["orderBy"]) && isset($_GET["orderMode"]) ) {

                $orderBy = $_GET["orderBy"];

                $orderMode = $_GET["orderMode"];

            } else {

                $orderBy = null;

                $orderMode = null;

            }

            // PREGUNTAMOS SI VIENEN VARIABLES DE LIMITES
            if ( isset($_GET["startAt"]) && isset($_GET["endAt"]) ) {

                $startAt = $_GET["startAt"];
                
                $endAt = $_GET["endAt"];

            } else {

                $startAt = null;

                $endAt = null;

            }
            
            if ( explode("?", $rutasArray[1])[0] == "relations" && isset($_GET["rel"]) && isset($_GET["type"]) ) {
                
                $respuesta = new GetControlador();
                $respuesta -> getDatosBusquedaRelacion($_GET["rel"], $_GET["type"],$_GET["linkTo"], $_GET["search"], $orderBy, $orderMode, $startAt, $endAt);

            } else {

                $respuesta = new GetControlador();
                $respuesta -> getDatosBusqueda(explode("?", $rutasArray[1])[0], $_GET["linkTo"], $_GET["search"], $orderBy, $orderMode, $startAt, $endAt);
    
            }
            
        // PETICIONES GET SIN FILTRO
        } else {

            // PREGUNTAMOS SI VIENEN VARIABLES DE ORDEN
            if ( isset($_GET["orderBy"]) && isset($_GET["orderMode"]) ) {

                $orderBy = $_GET["orderBy"];

                $orderMode = $_GET["orderMode"];

            } else {

                $orderBy = null;

                $orderMode = null;

            }

            // PREGUNTAMOS SI VIENEN VARIABLES DE LIMITES
            if ( isset($_GET["startAt"]) && isset($_GET["endAt"]) ) {

                $startAt = $_GET["startAt"];
                
                $endAt = $_GET["endAt"];

            } else {

                $startAt = null;

                $endAt = null;

            }

            $respuesta = new GetControlador();

            $respuesta -> getDatos(explode("?", $rutasArray[1])[0], $orderBy, $orderMode, $startAt, $endAt);

        }

    }

    // PETICIONES TIPO POST
    if ( count( $rutasArray ) == 1 && isset( $_SERVER["REQUEST_METHOD"] ) && $_SERVER["REQUEST_METHOD"] == "POST" ) {

        // TRAEMOS EL LISTADO DE COLUMNAS DE LA TABLA A MODIFICAR
        $columnas = array();

        $tabla = explode("?", $rutasArray[1])[0];
        
        $database = ControladorRutas::database();

        $respuesta = PostControlador::getDatosColumna($tabla, $database);

        foreach ($respuesta as $key => $value) {

            array_push($columnas, $value->item);

        }
        
        // QUITAR EL PRIMER Y ULTIMO INDICE
        array_shift($columnas);
        array_pop($columnas);

        // RECIBIMOS LOS VALORES POST
        if ( isset( $_POST ) ) {

            // VALIDAMOS QUE LAS VARIABLES POST COINCIDAN CON LA BASE DE DATOS
            $contador = 0;  

            foreach (array_keys($_POST) as $key => $value) {
               
                $contador = array_search($value, $columnas);
            
            }

            if ( $contador > 0 ) {

                // SOLICITAMOS RESPUESTA DEL CONTROLADOR PARA REGISTRAR USUARIOS
                if ( isset($_GET["register"]) && $_GET["register"] == true ){

                    $respuesta = new PostControlador();
                    $respuesta -> postRegistro($tabla, $_POST);

                // SOLICITAMOS RESPUESTA DEL CONTROLADOR PARA INGRESAR USUARIOS
                } else if ( isset($_GET["login"]) && $_GET["login"] == true ) {
                    
                    $respuesta = new PostControlador();
                    $respuesta -> postIngreso($tabla, $_POST);
                    
                // VALIDAR TOKEN DE AUTENTICACION
                } else if ( isset($_GET["token"]) ) {

                    // TRAEMOS EL USUARIO DE ACUERDO AL TOKEN
                    $usuario = GetModelo::getDatosFiltro("usuarios", "token_usuario", $_GET["token"], null, null, null, null);

                    if ( !empty($usuario) ) {

                        // VALIDAMOS EL TOKEN NO HAYA EXPIRADO
                        $tiempo = time();

                        if ( $usuario[0] -> token_exp_usuario > $tiempo ) {

                            // SOLICITAMOS RESPUESTA DEL CONTROLADOR PARA CREAR DATOS EN CUALQUIER TABLA
                            $respuesta = new PostControlador();
                            $respuesta -> postDatos($tabla, $_POST);

                        } else {

                            $json = array(
                                'estado' => 400,
                                'resultado' => "Error: El token ha expirado"
                            );
            
                            echo json_encode($json, http_response_code($json["estado"]));
            
                            return; 

                        }

                    } else {

                        $json = array(
                            'estado' => 400,
                            'resultado' => "Error: El usuario no esta autorizado"
                        );
        
                        echo json_encode($json, http_response_code($json["estado"]));
        
                        return; 

                    }

                } else {

                    $json = array(
                        'estado' => 400,
                        'resultado' => "Error: Autorizacion requerida"
                    );
    
                    echo json_encode($json, http_response_code($json["estado"]));
    
                    return;    

                }                
                
            } else {

                $json = array(
                    'estado' => 400,
                    'resultado' => "Error: Los campos en el formulario no se encuentran en la base de datos"
                );

                echo json_encode($json, http_response_code($json["estado"]));

                return;

            }

        }

    }

    // PETICIONES TIPO PUT
    if ( count( $rutasArray ) == 1 && isset( $_SERVER["REQUEST_METHOD"] ) && $_SERVER["REQUEST_METHOD"] == "PUT" ) {

        // PREGUNTAMOS SI EL ID VIENE
        if ( isset($_GET['id']) && isset($_GET['nameId']) ) {
           
            $tabla = explode("?", $rutasArray[1])[0];
            $linkTo = $_GET["nameId"];
            $equalTo = $_GET["id"];
            $orderBy = null;
			$orderMode = null;
			$startAt = null;
			$endAt = null;

            $respuesta = PutControlador::getDatosFiltro($tabla, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

            // VALIDAMOS QUE EXISTA EL ID
            if ( $respuesta ) {

                // CAPTURAMOS LOS DATOS DEL FORMULARIO
                $datos = array();

                parse_str(file_get_contents('php://input'), $datos);

                // TRAEMOS EL LISTADO DE COLUMNAS DE LA TABLA A CAMBIAR
                $columnas = array();

                $database = ControladorRutas::database();

                $respuesta = PostControlador::getDatosColumna(explode("?", $rutasArray[1])[0], $database);

                foreach ($respuesta as $key => $value) {
                    
                    array_push($columnas, $value -> item);

                }

                // QUITAMOS EL PRIMER Y Y LOS DOS ULTIMOS INDICES
                array_shift($columnas);
                array_pop($columnas);
                array_pop($columnas);

                // VALIDAMOS QUE LAS VARIABLES DE LOS CAMPOS PUT COINCIDAN CON LOS NOMBRES DE LAS COLUMNAS DE LA BASE DE DATOS
                $contador = 0;

                foreach (array_keys($datos) as $key => $value) {
                    
                    $contador = array_search($value, $columnas);

                }

                if ( $contador > 0 ) {

                    if ( isset($_GET["token"]) ) {

                        // TRAEMOS EL USUARIO DE ACUERDO AL TOKEN DE ACCESO
                        $usuario = GetModelo::getDatosFiltro("usuarios", "token_usuario", $_GET["token"], null, null, null, null);

                        if ( !empty($usuario) ) {

                            // VALIDAMOS QUE EL TOKE NO HAYA EXPIRADO
                            $tiempo = time();

                            if ( $usuario[0] -> token_exp_usuario > $tiempo ){

                                // SOLICITAMOS RESPUESTA DEL CONTROLADOR PARA EDITAR CUALQUIER TABLA
                                $respuesta = new PutControlador();
                                $respuesta -> putDatos(explode("?", $rutasArray[1])[0], $datos, $_GET["id"], $_GET["nameId"]);

                            } else {
                                
                                $json = array(
                                    'estado' => 400,
                                    'resultado' => "Error: El token ha expirado"
                                );
                                
                                echo json_encode($json, http_response_code($json["estado"]));
                                
                                return;

                            }

                        } else {
                            
                            $json = array(
                                'estado' => 400,
                                'resultado' => "Error: El usuario no esta autorizado"
                            );
                            
                            echo json_encode($json, http_response_code($json["estado"]));
                            
                            return;

                        }
                        
                    } else {

                        $json = array(
                            'estado' => 400,
                            'resultado' => "Error: Autorizacion requerida"
                        );
                        
                        echo json_encode($json, http_response_code($json["estado"]));
                        
                        return;

                    }

                } else {

                    $json = array(
                        'estado' => 400,
                        'resultado' => "Error: Los campos en el formulario no se encuentran en la base de datos"
                    );
                    
                    echo json_encode($json, http_response_code($json["estado"]));
                    
                    return;

                }

            } else {
                $json = array(
                    'estado' => 400,
                    'resultado' => "Error: El id no se encuentra en la base de datos"
                );
                
                echo json_encode($json, http_response_code($json["estado"]));
                
                return;

            }
            
        }

    }

    // PETICIONES TIPO DELETE
    if ( count( $rutasArray ) == 1 && isset( $_SERVER["REQUEST_METHOD"] ) && $_SERVER["REQUEST_METHOD"] == "DELETE" ) {

        // PREGUNTAMOS SI VIENE ID
        if ( isset($_GET["id"]) && isset($_GET["nameId"]) ) {

            // VALIDAMOS QUE EXISTA EL ID
            $tabla = explode("?", $rutasArray[1])[0];
            $linkTo = $_GET["nameId"];
            $equalTo = $_GET["id"];
            $orderBy = null;
            $orderMode = null;
            $startAt = null;
            $endAt = null;

            $respuesta = PutControlador::getDatosFiltro($tabla, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

            if ( $respuesta ) {

                if ( isset($_GET["token"]) ) {

                    // TRAEMOS EL USUARIO DE ACUERDO AL TOKEN
                    $usuario = GetModelo::getDatosFiltro("usuarios", "token_usuario", $_GET["token"], null, null, null, null);

                    if ( !empty($usuario) ) {

                        // VALIDAMOS QUE EL TOKEN NO HAYA EXPIRADO
                        $tiempo = time();

                        if ( $usuario[0] -> token_exp_usuario > $tiempo ) {

                            // SOLICITAMOS RESPUESTA DEL CONTROLADOR
                            $respuesta = new DeleteControlador();
                            $respuesta ->deleteDatos(explode("?", $rutasArray[1])[0], $_GET["id"], $_GET["nameId"]);

                        } else {
                            
                            $json = array(
                                'estado' => 400,
                                'resultado' => "Error: El token ha expirado"
                            );
                            
                            echo json_encode($json, http_response_code($json["estado"]));
                            return;

                        }

                    } else {

                        $json = array(
                            'estado' => 400,
                            'resultado' => "Error: El usuario no esta autorizado"
                        );
                        
                        echo json_encode($json, http_response_code($json["estado"]));
                        return;

                    }

                } else {
                    
                    $json = array(
                        'estado' => 400,
                        'resultado' => "Error: Autorizacion requerida"
                    );
                    
                    echo json_encode($json, http_response_code($json["estado"]));
                    return;

                }

            } else {

                $json = array(
                    'estado' => 400,
                    'resultado' => "Error: El id no se encuentra en la base de datos"
                );
                
                echo json_encode($json, http_response_code($json["estado"]));
                return;

            }

        }

    }

}
