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
            echo $error->getMessage();
        }
    }

    public function obtenerMenuRoles($idRol){     
        //establecemos la coneccion
        $this->con = Conexion::conectar();
        //establecemos la consulta
        $sql="select a.id_menu,a.nombre_menu from menu a inner join rol_menu b on a.id_menu = b.id_menu
        where b.id_rol = ?";
        //preparamos la consulta
        $respuesta =$this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros
            $respuesta->execute([$idRol]);

            //retornamos el arreglo
            return $respuesta->fetchAll(PDO::FETCH_ASSOC);
           
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

    public function obtenerAccRoles($idRol){     
        //establecemos la coneccion
        $this->con = Conexion::conectar();
        //establecemos la consulta
        $sql="select a.nombre_accion from acciones a inner join rol_acciones b on a.id_accion = b.id_accion
        where b.id_rol = ?";
        //preparamos la consulta
        $respuesta =$this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros
            $respuesta->execute([$idRol]);

            //retornamos el arreglo
            return $respuesta->fetchAll(PDO::FETCH_ASSOC);
           
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }
}