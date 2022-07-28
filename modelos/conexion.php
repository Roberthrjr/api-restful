<?php

class Conexion
{

    static public function conectar()
    {

        try {

            $enlace = new PDO("mysql:host=localhost; dbname=reino_animalia", "root", "2r?krWv&?v!O");

            $enlace->exec("set names utf8");

        } catch ( PDOException $e ) {
            
            die("Error: ".$e -> getMessage());

        }

        return $enlace;
    
    }
}
