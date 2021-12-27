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

    

}

?>