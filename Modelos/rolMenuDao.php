<?php
include "rolMenu.php";
include_once 'conexion.php';

class RolMenuDao{
    private $con;

    public function __construct(){

        
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
    public function insertarRolMenu($objeto){
        $rm = new RolMenu();
        $rm = $objeto;
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="insert into rol_menu values (?,?)";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([
                $rm->getIdRol(),
                $rm->getIdMenu()
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