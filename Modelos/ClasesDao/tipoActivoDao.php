<?php

include dirname(__DIR__, 1).'/clases/tipoActivo.php';
include_once dirname(__DIR__, 1).'/conexion.php';

class tipoActivoDao{

    public function __construct()
    {
    }

    public function insertarTipoActivo($objeto){
        $re = $objeto;
        $con = Conexion::conectar();
        $sql = "INSERT INTO Tipo_Activo(
            tipo_activo_id,
            tipo_activo_nombre,
            usuario_id,
            fecha)
            VALUES (?,?,?,CURRENT_TIMESTAMP)";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $re->getTipoActivoId(),
                $re->getTipoActivoNombre(),
                $re->getUsuarioId()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function modificarTipoActivo($objeto){
        $re = $objeto;
        $con = Conexion::conectar();
        $sql = "UPDATE Tipo_Activo SET
            tipo_activo_nombre = ?,
            usuario_id = ?,
            fecha = CURRENT_TIMESTAMP
            WHERE tipo_activo_id = ?";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $re->getTipoActivoNombre(),
                $re->getUsuarioId(),
                $re->getTipoActivoId()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function eliminarTipoActivo($id){
        $con = Conexion::conectar();
        $sql = "DELETE FROM Tipo_Activo WHERE tipo_activo_id = ?";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([$id]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function mostrarTipoActivo(){
        $con = Conexion::conectar();
        $sql = "SELECT * FROM Tipo_Activo";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute();
            $data = $respuesta->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function countTipActivo($idTipAct){
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select count(*) as totalTipActivo from activo where Activo_tipo =?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
        
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$idTipAct]);
            //retornamos la cantidad de registro con el correo ingresado
            //solo puede ser 1 si hay o 0 si no hay
            return $respuesta->fetchColumn();
        
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

    public function countTipImpre($descripcion){
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select count(*) from Activo where Activo_tipo = 3 AND Activo_descripcion LIKE ?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
        
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute(['%'.$descripcion.'']);
            //retornamos la cantidad de registro con el correo ingresado
            //solo puede ser 1 si hay o 0 si no hay
            return $respuesta->fetchColumn();
        
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }
}

?>