<?php
include "roles.php";
include_once 'conexion.php';

class RolesDao{
    private $con;

    public function __construct(){

        
    }

    public function obtenerCmbRoles(){     
        //establecemos la coneccion
        $this->con = Conexion::conectar();
        //establecemos la consulta
        $sql="select id_rol,rol_nombre from roles;";
        try{
            //ejecutamos la consulta 
            $respuesta = $this->con->query($sql);

            //retornamos el arreglo
            return $respuesta->fetchAll();
           
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }
}