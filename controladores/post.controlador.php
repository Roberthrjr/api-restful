<?php 

use Firebase\JWT\JWT;

class PostControlador {

    // PETICION POST PARA CREAR DATOS
    public function postDatos($tabla, $datos) {

        $respuesta = PostModelo::postDatos($tabla, $datos);

        $retornar = new PostControlador();

        $retornar -> fncRespuesta($respuesta, "postDatos", null);
    }

    // PETICION PARA TOMAR LOS NOMBRE DE LAS COLUMNAS
    static public function getDatosColumna($tabla, $database) {

        $respuesta = PostModelo::getDatosColumna($tabla, $database);

        return $respuesta;

    }

    // PETICION POST PARA REGISTRAR USUARIO
    static public function postRegistro($tabla, $datos){

        if ( isset($datos["contrasena_usuario"]) && $datos["contrasena_usuario"] != null ) {

            $crypt = crypt($datos["contrasena_usuario"], '$2a$07$azybxcags23425sdg23sdfhsd$');

            $datos["contrasena_usuario"] = $crypt;

            $respuesta = PostModelo::postDatos($tabla, $datos);

            $retornar = new PostControlador();
            $retornar -> fncRespuesta($respuesta, "postRegistro", null);

        }

    }

    // PETICION POST PARA EL INGRESO DE USUARIO
    static public function postIngreso($tabla, $datos){

        $respuesta = GetModelo::getDatosFiltro($tabla, "correo_usuario", $datos["correo_usuario"], null, null, null, null);

        if ( !empty($respuesta) ) {

            // ENCRIPTAR LA CONTRASEÑA
            $crypt = crypt($datos["contrasena_usuario"], '$2a$07$azybxcags23425sdg23sdfhsd$');

            if ( $respuesta[0]->contrasena_usuario == $crypt ) {

                // CREACION DE JWT
                $tiempo = time();
                $key = "azscdvfbgnhmjkl1q2w3e4r5t6y7u8i9o";

                $token = array(
                    "iat" => $tiempo, //Tiempo que inicio el token
                    "exp" => $tiempo + (60*60*24), // Tiempo que expirara el token (+1dia)
                    'data' => [
                        "id" => $respuesta[0]->id_usuario,
                        "email" => $respuesta[0]->correo_usuario
                    ]
                );

                $alg = 'HS256';
                $keyId = null;
                $head = null;

                $jwt = JWT::encode($token,$key,$alg,$keyId,$head);

                // ACTUALIZAMOS LA BASE DE DATOS CON EL YOKEN DEL USUARIO
                $datos = array(
					"token_usuario" => $jwt,
					"token_exp_usuario" => $token["exp"]
				);

                $update = PutModelo::putDatos($tabla, $datos, $respuesta[0]->id_usuario, "id_usuario");

                if ( $update == "The process was successful" ) {

                    $respuesta[0]->token_usuario = $jwt;
                    $respuesta[0]->token_exp_usuario = $token["exp"];

                    $retornar = new PostControlador();
                    $retornar->fncRespuesta($respuesta, "postIngreso", null);    

                }

            } else {

                $respuesta = null;

                $retornar = new PostControlador();
                $retornar->fncRespuesta($respuesta, "postIngreso", "Contrasena equivocada");

            }

        } else {

            $respuesta = null;

            $retornar = new PostControlador();
            $retornar->fncRespuesta($respuesta, "postIngreso", "Email equivocado");

        }

    }

    // RESPUESTAS DEL CONTROLADOR
    public function fncRespuesta($respuesta, $metodo, $error) {

        if ( !empty($respuesta) ) {

            // QUITAMOS LA CONTRASEÑA DE LA RESPUESTA

            if ( isset($respuesta[0] -> contrasena_usuario) ) {

                unset($respuesta[0] -> contrasena_usuario);

            }

            $json = array(
                'estado' => 200,
                'resultados' => $respuesta
            );

        } else {

            if ( $error != null ) {

                $json = array(
                    'estado' => 404,
                    'resultados' => $error
                );

            } else {

                $json = array(
                    'estado' => 404,
                    'resultados' => "No encontrado",
                    'metodo' => $metodo
                );
            }

        }

        echo json_encode($json, http_response_code($json["estado"]));

        return;

    }

}

?>