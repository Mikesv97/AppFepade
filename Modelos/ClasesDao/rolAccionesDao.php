<?php
include dirname(__DIR__, 1)."/clases/rolAcciones.php";
include_once dirname(__DIR__, 1).'/conexion.php';

class RolAccionesDao{
    private $con;

    public function __construct(){

        
    }

    public function obtenerAccRoles($idRol){     
        //establecemos la coneccion
        $this->con = Conexion::conectar();
        //establecemos la consulta
        $sql="select a.id_accion, a.nombre_accion from acciones a inner join rol_acciones b on a.id_accion = b.id_accion
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

    public function insertarRolAcciones($objeto){
        $ra = new RolAcciones();
        $ra = $objeto;
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="insert into rol_acciones values (?,?)";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([
                $ra->getIdRol(),
                $ra->getIdAccion()
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

    public function eliminarRolAcciones($idRol){
        $ra = new RolAcciones();
        $ra ->setIdRol($idRol);
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="delete from rol_acciones where id_rol = ?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([
                $ra->getIdRol()
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