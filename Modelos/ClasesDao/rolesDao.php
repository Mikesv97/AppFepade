<?php
include dirname(__DIR__, 1)."/clases/roles.php";
include_once dirname(__DIR__, 1).'/conexion.php';

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
                //si se afectaron m??s de 0
                return true;                 
            }else{
                return false;
            }
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

    public function editarRol($objeto){
        $r = new Roles();
        $r = $objeto;
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="update roles set rol_nombre =?, rol_descripcion=? where id_rol =?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([
                $r->getNombreRol(),
                $r->getDescripcionRol(),
                $r->getIdRol()
            ]);
            //evaluamos cuantas filas fueron afectadas
            if($respuesta->rowCount() > 0){
                //cerramos conexion
               Conexion::desconectar($respuesta);
                //si se afectaron m??s de 0
                return true;                 
            }else{
                return false;
            }
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

    public function eliminarRol($idRol){
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="delete from roles where id_rol =?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$idRol]);
            //evaluamos cuantas filas fueron afectadas
            if($respuesta->rowCount() > 0){
                //cerramos conexion
               Conexion::desconectar($respuesta);
                //si se afectaron m??s de 0
                return true;                 
            }else{
                return false;
            }
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

    public function verificarRolAsignado($idRol){
            //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select count(*) as rol_asignado from Usuario where id_rol = ?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$idRol]);
            //evaluamos cuantas filas fueron afectadas
            return $respuesta->fetchColumn();
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }
}