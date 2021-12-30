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

    public function obtenerRoles(){     
        //establecemos la coneccion
        $this->con = Conexion::conectar();
        //establecemos la consulta
        $sql="select * from roles";
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

    public function obtenerMaxIdRol(){
        //establecemos la coneccion
        $this->con = Conexion::conectar();
        //establecemos la consulta
        $sql="select max(id_rol) as LastId from roles";
        try{
            //ejecutamos la consulta 
            $respuesta = $this->con->query($sql);
        
            //retornamos el arreglo
            return $respuesta->fetchColumn();
                   
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

    public function insertarRol($objeto){
        $r = new Roles();
        $r = $objeto;
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="insert into roles values (?,?)";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([
                $r->getNombreRol(),
                $r->getDescripcionRol()
            ]);
            //evaluamos cuantas filas fueron afectadas
            if($respuesta->rowCount() > 0){
                //cerramos conexion
               Conexion::desconectar($respuesta);
                //si se afectaron más de 0
                return true;                 
            }else{
                return false;
            }
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

}