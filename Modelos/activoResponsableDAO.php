<?php

include 'activoResponsable.php';
include_once 'conexion.php';

class activoResponsableDao{

    public function __construct(){
    }

    public function insertarResponsable($objeto){
        $re = $objeto;
        $con = Conexion::conectar();
        $sql = "INSERT INTO Activo_responsable(
            Codigo_responsable,
            Nombre_Responsable,
            Estado)
            VALUES (?,?,?)";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $re->getCodigoResponsable(),
                $re->getNombreResponsable(),
                $re->getEstado()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function modificarResponsable($objeto){
        $re = $objeto;
        $con = Conexion::conectar();
        $sql = "UPDATE Activo_responsable SET
            Codigo_responsable = ?,
            Nombre_Responsable = ?,
            Estado = ?
            WHERE Responsable_codigo = ?";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $re->getCodigoResponsable(),
                $re->getNombreResponsable(),
                $re->getEstado(),
                $re->getResponsableCodigo()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function eliminarResponsable($id){
        $con = Conexion::conectar();
        $sql = "DELETE FROM Activo_responsable WHERE Responsable_codigo = ?";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([$id]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function mostrarActivoResponsable(){
        $con = Conexion::conectar();
        $sql = "SELECT * FROM Activo_responsable";
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