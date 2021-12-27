<?php

include 'tipoActivo.php';
include_once 'conexion.php';

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

}

?>