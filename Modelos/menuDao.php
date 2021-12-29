<?php
include "menu.php";
include_once 'conexion.php';

class MenuDao{
    private $con;

    public function __construct(){

        
    }

    public function obtenerMenu(){     
        //establecemos la coneccion
        $this->con = Conexion::conectar();
        //establecemos la consulta
        $sql="select * from menu";
        //preparamos la consulta
        try{
            //ejecutamos la consulta y seteamos parametros
            $respuesta = $this->con->query($sql);

            //retornamos el arreglo
            return $respuesta->fetchAll(PDO::FETCH_ASSOC);
           
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }
}