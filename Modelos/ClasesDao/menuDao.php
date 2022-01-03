<?php
include dirname(__DIR__, 1)."/clases/menu.php";
include_once dirname(__DIR__, 1).'/conexion.php';

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

    public function insertarMenu($objeto){
        $m = new Menu();
        $m = $objeto;
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="insert into menu values (?,?,?)";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([
                $m->getNombreMenu(),
                $m->getDireccionWeb(),
                $m->getMenuPadre()
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

    public function editarMenu($objeto){
        $m = new Menu();
        $m = $objeto;
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="update menu set nombre_menu=?, direccion_web =?, menu_padre =? where id_menu =?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([
                $m->getNombreMenu(),
                $m->getDireccionWeb(),
                $m->getMenuPadre(),
                $m->getIdMenu()
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

    public function eliminarMenu($idMenu){
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="delete from menu where id_menu = ?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([
                $idMenu
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

    public function verificarMenuAsignado($idMenu){
        //establecemos la coneccion
    $con = Conexion::conectar();
    //establecemos la consulta
    $sql="select count(*) as menu_asignado from rol_menu where id_menu = ?";
    //preparamos la consulta
    $respuesta = $con->prepare($sql);
    try{
        //ejecutamos la consulta y seteamos parametros 
        $respuesta->execute([$idMenu]);
        //evaluamos cuantas filas fueron afectadas
        return $respuesta->fetchColumn();
    }catch(PDOException $error){
        echo $error->getMessage();
    }
}
}