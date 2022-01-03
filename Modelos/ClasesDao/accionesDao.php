<?php
include dirname(__DIR__, 1)."/clases/acciones.php";
include_once  dirname(__DIR__,1).'/conexion.php';

class AccionesDao{
    private $con;

    public function __construct(){

        
    }

    public function obtenerAcciones(){     
        //establecemos la coneccion
        $this->con = Conexion::conectar();
        //establecemos la consulta
        $sql="select * from acciones";
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